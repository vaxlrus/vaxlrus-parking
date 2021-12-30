<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Api;
use App\Repository;

// Объект репозитория
$repository = new Repository(__DIR__ . '/../configs');

// Объект API
$api = new Api($repository);

//$response = $api->createParking(10);
$response = $api->getParking(9999);

var_dump($response->getData());