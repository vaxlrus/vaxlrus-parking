<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Api;
use App\Repository;

// Объект репозитория
$repository = new Repository();

// Объект API
$api = new Api();

// Объект парковки
$parking = $api->createParking(40);
echo "Объект парковки в исходном виде\n";
var_dump($parking);


// Сохранение парковки
$repository->save($parking);
echo "Загрузка объекта из файла\n";
var_dump($repository->load('0'));

echo "Загрузка всех объектов из файлов. Представление в виде массива:\n";
var_dump($repository->loadAll());

// Удаление парковки
$repository->removeParking(0);

// Проверить есть ли такая парковка путем повторного удаления
$repository->removeParking(0);