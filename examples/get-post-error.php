<?php

use scarbo87\RestApiSdk\Operator\V1\PostOperator;
use scarbo87\RestApiSdk\Transport\Exception\code400\NotFoundException;

list($client, $mapper, $config) = require __DIR__ . "/bootstrap.php";

try {
    $operator = new PostOperator($client, $mapper);
    $post = $operator->find(200);
} catch (NotFoundException $e) {
    echo $e->getMessage(), PHP_EOL;
}