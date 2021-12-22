<?php

namespace App;

class Parking
{
    private int $capacity;

    public function __construct(int $capacity)
    {
        try
        {
            $this->parkingCreation($capacity);
        }
        catch (\DomainException $error)
        {
            echo $error->getMessage() . PHP_EOL;
        }
    }

    private function parkingCreation(int $capacity)
    {
        if ($capacity == 0)
        {
            throw new \DomainException('Парковка не может быть создана без мест');
        }

        if ($capacity < 0)
        {
            throw new \DomainException('Парковка не может иметь отрицательную вместимость');
        }

        $this->capacity = $capacity;
    }
}