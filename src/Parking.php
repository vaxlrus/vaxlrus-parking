<?php

namespace App;

class Parking
{
    private int $capacity;

    public function __construct(int $capacity)
    {
        $this->isCapacityValid($capacity);

        $this->capacity = $capacity;
    }

    private function isCapacityValid(int $capacity)
    {
        if ($capacity == 0)
        {
            throw new \DomainException('Парковка не может быть создана без мест');
        }

        if ($capacity < 0)
        {
            throw new \DomainException('Парковка не может иметь отрицательную вместимость');
        }

        if (gettype($capacity) != 'integer')
        {
            throw new \DomainException('Вместимость парковки можно задавать только целочисленным типом данных');
        }
    }
}