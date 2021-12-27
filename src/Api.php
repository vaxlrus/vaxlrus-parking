<?php

namespace App;

use App\Parking\Parking;

class Api
{
    // Создание парковки
    public function createParking(int $capacity): Parking
    {
        return new Parking($capacity);
    }
}