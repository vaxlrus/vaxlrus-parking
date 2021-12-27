<?php

namespace App\Parking;

abstract class Vehicle
{
    private string $vin;

    public function __construct(string $vin)
    {
        $this->vin = $vin;
    }

    // Получение вин номера транспортного средства
    public function getVin(): string
    {
        return $this->vin;
    }

    // Получение размера ТС
    public function getSize(): float
    {
        return static::SIZE;
    }
}