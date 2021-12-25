<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Parking;
use App\Auto;

// Инициализация парковки с двумя стояночными местами
$parking = new Parking(10);

// Создание 4 автомобилей
$auto1 = new Auto('JH4DA9460MS032070');
$auto2 = new Auto('WVWSB61J71W607153');
$auto3 = new Auto('WVWSB61J71W607153');

// Парковка 4 автомобилей
var_dump($parking->park($auto1));
var_dump($parking->park($auto2));
var_dump($parking->park($auto3));

// Выпарковка авто
var_dump($parking->unpark($auto1->getVin()));
var_dump($parking->unpark($auto2->getVin()));
var_dump($parking->unpark($auto3->getVin()));
