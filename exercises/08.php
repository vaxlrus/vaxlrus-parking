<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Api;

$api = new Api();

// Создание парковки через Api
var_dump($api->createParking(40));