<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Api;
use App\Repository;

// Объект репозитория
$repository = new Repository(__DIR__ . '/../configs');

// Объект API
$api = new Api($repository);

// Создать новую парковку
//var_dump($api->getAllParkings());

// Поставить ТС на парковку
//var_dump($api->parkVehicle(2, 'Truck', '1FA6P8TH8F5351794'));
var_dump($api->parkVehicle(2, 'Truck', '2FA6P8TH8F5351794'));

// Получить конкретную парковку
var_dump($api->getParking(2));

// Выгнать ТС с парковки
//var_dump($api->unparkVehicle(2, '1FA6P8TH8F5351794'));

// Удалить парковку
//var_dump($api->removeParking(3));

