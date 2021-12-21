<?php

namespace App;

class Parking
{
    private int $capacity;

    public function __construct(int $capacity)
    {
        $this->capacity = $capacity;
    }
}