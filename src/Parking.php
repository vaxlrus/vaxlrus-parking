<?php

namespace App;

class Parking
{
    private int $capacity;

    public function __construct(int $capacity)
    {
        $this->assertCapacityIsValid($capacity);

        $this->capacity = $capacity;
    }

    private function assertCapacityIsValid(int $capacity): void
    {
        if ($capacity == 0)
        {
            throw new \DomainException('Парковка не может быть создана без мест');
        }

        if ($capacity < 0)
        {
            throw new \DomainException('Парковка не может иметь отрицательную вместимость');
        }
    }
}