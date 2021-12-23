<?php

namespace App;

class Parking
{
    private int $capacity; // Общая вместимость паркинга
    private int $availableSpace; // Количество cвободных мест
    private array $parking; // Хранилище автомобилей

    public function __construct(int $capacity)
    {
        // Проверить аргумент на соответствие правилам создания парковки
        $this->assertCapacityIsValid($capacity);

        // Задать вместимость парковки
        $this->capacity = $capacity;

        // Задать количество свободных мест на парковке равным количеству мест на парковке
        $this->availableSpace = $capacity;
    }

    // Проверка соответствия значения вместимости парковки
    private function assertCapacityIsValid(int $capacity): void
    {
        // Если парковка создается с нулевым пространством
        if ($capacity == 0)
        {
            throw new \DomainException('Парковка не может быть создана без мест');
        }

        // Если парковка создается с отрицательным пространством
        if ($capacity < 0)
        {
            throw new \DomainException('Парковка не может иметь отрицательную вместимость');
        }
    }

    // Метод парковки авто
    public function parkAuto(Auto $auto): bool
    {
        // Если парковка полная, вернуть false
        if ($this->assertParkingIsFull()) return false;

        // Добавить авто на парковку
        $this->parking[] = $auto;
        // Уменьшить количество свободных мест
        $this->availableSpace--;

        return true;
    }

    // Метод проверки заполненности парковки
    private function assertParkingIsFull(): bool
    {
        return ($this->availableSpace == 0);
    }

    // Получить количество свободных мест
    public function getAvailableSpace()
    {
        return $this->availableSpace;
    }
}