<?php

namespace App;

class Parking
{
    private int $capacity;

    public function __construct(int $availableSpace)
    {
        $this->capacity = $availableSpace;
    }
}