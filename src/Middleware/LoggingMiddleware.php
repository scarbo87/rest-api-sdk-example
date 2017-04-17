<?php

namespace scarbo87\RestApiSdk\Middleware;

use function GuzzleHttp\Psr7\str;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use scarbo87\RestApiSdk\Context;
use scarbo87\RestApiSdk\Exception\SdkException;
use scarbo87\RestApiSdk\Transport\Exception\RequestException;
use scarbo87\RestApiSdk\Transport\Middleware\HttpMiddleware;
use scarbo87\RestApiSdk\Transport\Middleware\HttpMiddlewareStack;

class LoggingMiddleware implements HttpMiddleware
{
    /** @var LoggerInterface */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function request(RequestInterface $request, HttpMiddlewareStack $stack, Context $context)
    {
        try {
            $response = $stack->request($request, $context);
            $this->log($request, $response);

            return $response;
        } catch (RequestException $e) {
            $this->logError($request, $e);
            throw $e;
        }
    }

    protected function log(RequestInterface $request, ResponseInterface $response)
    {
        $this->logger->debug(sprintf('Request: %s', str($request)));
        $this->logger->info(sprintf('Response: %s', str($response)));
    }

    protected function logError(RequestInterface $request, RequestException $e)
    {
        $this->logger->debug(sprintf('Request: %s', str($request)));
        $this->logger->error(str($e->response));
    }
}