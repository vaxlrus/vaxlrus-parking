<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Api;
use App\Repository;

// Объект репозитория
$repository = new Repository(__DIR__ . '/../configs');

// Объект API
$api = new Api($repository);

// Создать новую парковку
$parking = $api->createParking(40);

echo "Загрузка всех объектов из файлов. Представление в виде массива:\n";
var_dump($repository->loadAll());

// Удаление парковки
$repository->removeParking(0);

// Проверить есть ли такая парковка путем повторного удаления
//$repository->removeParking(2);