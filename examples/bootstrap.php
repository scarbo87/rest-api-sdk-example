<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Client as GuzzleClient;
use scarbo87\RestApiSdk\Transport\RequestFactory;
use scarbo87\RestApiSdk\Transport\GuzzleHttpTransport;
use scarbo87\RestApiSdk\Transport\Middleware\HttpMiddlewareStackPrototype;
use scarbo87\RestApiSdk\Transport\Middleware\Impl\ResponseValidatingMiddleware;
use scarbo87\RestApiSdk\Client;
use scarbo87\RestApiSdk\Middleware\LoggingMiddleware;

$autoloader = require_once __DIR__ . '/../vendor/autoload.php';
AnnotationRegistry::registerLoader([$autoloader, 'loadClass']);


$config = include __DIR__ . '/.config.php';
$baseUri = new Uri('https://jsonplaceholder.typicode.com');

$requestFactory = new RequestFactory($baseUri);
$http = new GuzzleHttpTransport(new GuzzleClient());

$httpStack = HttpMiddlewareStackPrototype::newEmpty($http);
$httpStack->push(new ResponseValidatingMiddleware());
$httpStack->push(new LoggingMiddleware($config['logger']));

$client = new Client($requestFactory, $httpStack);

$mapper = \scarbo87\RestApiSdk\simpleMapper(true);

return [$client, $mapper, $config];
