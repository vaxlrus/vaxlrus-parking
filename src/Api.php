<?php

namespace App;

use App\Parking\Parking;
use App\Repository;

class Api
{
    private Repository $repo;

    public function __construct(Repository $repo)
    {
        $this->repo = $repo;
    }

    // Создание парковки
    public function createParking(int $capacity): Parking
    {
        // Создать парковку
        $parking = new Parking($capacity);

        // Сохранить парковку в файл
        $this->repo->save($parking, $this->repo->nextId());

        return $parking;
    }
}