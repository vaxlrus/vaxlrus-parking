<?php

namespace App;

class Parking
{
    private int $parkingCapacity; // Общая вместимость паркинга
    private array $carStorage = []; // Хранилище автомобилей

    public function __construct(int $parkingCapacity)
    {
        // Если парковка создается с нулевым пространством
        if ($parkingCapacity == 0)
        {
            throw new \DomainException('Парковка не может быть создана без мест');
        }

        // Если парковка создается с отрицательным пространством
        if ($parkingCapacity < 0)
        {
            throw new \DomainException('Парковка не может иметь отрицательную вместимость');
        }

        // Задать вместимость парковки
        $this->parkingCapacity = $parkingCapacity;
    }

    // Метод парковки авто
    public function parkAuto(Auto $auto): bool
    {
        // Если количество занятых мест равно максимальному на парковке, то она переполнена: return false
        if (count($this->carStorage) == $this->parkingCapacity)
        {
            return false;
        }

        // Добавить авто на парковку
        $this->carStorage[] = $auto;

        return true;
    }

}