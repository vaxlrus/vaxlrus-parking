<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Parking;
use App\Auto;
use App\Motorcycle;
use App\Truck;

// Инициализация парковки с двумя стояночными местами
$parking = new Parking(10);

// Состояние парковки на момент создания
echo "Общее количество свободных мест на парковке: ";
var_dump($parking->getFreeSpaceCount());

// Создание 4 автомобилей
$auto = new Auto('JH4DA9460MS032070');
$moto = new Motorcycle('WVWSB61J71W607153');
$bus = new Truck('3N1BC13E99L480541');

// Парковка 4 автомобилей
$parking->park($auto);
$parking->park($moto);
$parking->park($bus);
echo "Транспортные средства припаркованы \n";

// Состояние парковки после парковки транспортных средств
echo "Количество свободных мест на парковке: ";
var_dump($parking->getFreeSpaceCount());

// Выпарковка авто
$parking->unpark($auto->getVin());
$parking->unpark($moto->getVin());
$parking->unpark($bus->getVin());
echo "Транспортные средства отпаркованы \n";

// Состояние парковки после отпарковки транспортных средств
echo "Количество свободных мест на парковке: ";
var_dump($parking->getFreeSpaceCount());
echo "\n";