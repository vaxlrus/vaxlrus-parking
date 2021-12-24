<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Parking;
use App\Auto;

// Инициализация парковки с двумя стояночными местами
$parking = new Parking(10);

// Создание 4 автомобилей
$auto1 = new Auto('JH4DA9460MS032070');
$auto2 = new Auto('1HD1BX510BB027648');
$auto3 = new Auto('WVWSB61J71W607153');
$auto4 = new Auto('3N1BC13E99L480541');

// Парковка 4 автомобилей
var_dump($parking->park($auto1));
var_dump($parking->park($auto2));
var_dump($parking->park($auto3));
var_dump($parking->park($auto4));

// Выпарковка авто
var_dump($parking->unpark($auto1->getVin()));
var_dump($parking->unpark($auto2->getVin()));
var_dump($parking->unpark($auto3->getVin()));
var_dump($parking->unpark($auto4->getVin()));
