<?php

use scarbo87\RestApiSdk\Operator\V1\PostOperator;

list($client, $mapper, $config) = require __DIR__ . "/bootstrap.php";

$operator = new PostOperator($client, $mapper);
$post = $operator->find(1);
var_dump($post);