<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Parking;
use App\Auto;

// Инициализация парковки с двумя стояночными местами
$parking = new Parking(40);

// Создание 4 автомобилей
$auto1 = new Auto();
$auto2 = new Auto();
$auto3 = new Auto();
$auto4 = new Auto();

// Парковка 4 автомобилей
var_dump($parking->park($auto1));
var_dump($parking->park($auto2));
var_dump($parking->park($auto3));
var_dump($parking->park($auto4));

?>