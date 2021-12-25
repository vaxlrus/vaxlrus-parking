<?php

namespace App;

use App\VehicleInterface;

abstract class Vehicle implements VehicleInterface
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
}