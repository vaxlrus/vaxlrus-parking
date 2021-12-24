<?php

namespace App;

class Auto
{
    private string $vin;

    public function __construct(string $vin)
    {
        $this->vin = $vin;
    }

    // Получение vin номера
    public function getVin(): string
    {
        return $this->vin;
    }
}