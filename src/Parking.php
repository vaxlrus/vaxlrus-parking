<?php

namespace App;

class Parking
{
    private int $totalCapacity; // Общая вместимость паркинга
    private array $carStorage = []; // Хранилище автомобилей

    public function __construct(int $totalCapacity)
    {
        // Если парковка создается с нулевым пространством
        if ($totalCapacity == 0)
        {
            throw new \DomainException('Парковка не может быть создана без мест');
        }

        // Если парковка создается с отрицательным пространством
        if ($totalCapacity < 0)
        {
            throw new \DomainException('Парковка не может иметь отрицательную вместимость');
        }

        // Задать вместимость парковки
        $this->$totalCapacity = $totalCapacity;
    }

    // Метод парковки авто
    public function park(Auto $auto): bool
    {
        // Если количество занятых мест равно максимальному на парковке, то она переполнена: return false
        if (count($this->carStorage) === $this->totalCapacity)
        {
            return false;
        }

        // Добавить авто на парковку
        $this->carStorage[] = $auto;

        return true;
    }

}