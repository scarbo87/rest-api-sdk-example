<?php

use scarbo87\RestApiSdk\Operator\V1\PostOperator;
use scarbo87\RestApiSdk\Domain\V1\Post;

list($client, $mapper, $config) = require __DIR__ . "/bootstrap.php";

$operator = new PostOperator($client, $mapper);
$post = $operator->create(new Post(1, 'test', 'test'));
var_dump($post);