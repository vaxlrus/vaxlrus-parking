<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Api;
use App\Repository;

// Объект репозитория
$repository = new Repository(__DIR__ . '/../configs');

// Объект API
$api = new Api($repository);

//var_dump($api->getParking(3));
var_dump($api->removeParking(1));
//var_dump($api->unparkVehicle(3, '111111111'));
//var_dump($api->parkVehicle(4, 'Auto','2222222222'));
//var_dump($api->getAllParkings());
//var_dump($api->createParking(10));