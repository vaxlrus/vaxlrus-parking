<?php

namespace App;

use App\Parking\Parking;
use App\Repository;
use App\Parking\Vehicle;
use App\ApiResponse;

class Api
{
    private Repository $repo;

    public function __construct(Repository $repo, ApiResponse $apiResponse)
    {
        $this->repo = $repo;
        $this->apiResponse = $apiResponse;
    }

    // Создание парковки
    public function createParking(int $capacity): array
    {
        // Создать парковку
        $parking = new Parking($capacity, $this->repo->nextId());

        // Сохранить парковку в файл
        $this->repo->save($parking);

        return $this->apiResponse->send($parking);
    }

    // Получить все парковки
    public function getAllParkings(): array
    {
        return $this->repo->loadAll();
    }

    // Получить конкретную парковку
    public function getParking(int $id): array
    {
        return $this->apiResponse->send($this->repo->load($id));
    }

    // Запарковать авто
    public function parkVehicle(int $parkingId, string $vehicleType, string $vin): array
    {
        // Загрузить объект парковки
        $parking = $this->repo->load($parkingId);

        // Если объект не является типом класса
        $classType = "App\\Parking\\{$vehicleType}";

        // Если переданный тип ТС не является дочерним классом абстрактного класса Vehicle, то выдать исключение
        if (!class_exists($classType) OR !is_subclass_of($classType, Vehicle::class))
        {
            throw new \DomainException('Объект типа ' . $vehicleType . ' не является транспортным средством');
        }

        // Создать тип транспортного средства
        $vehicle = new $classType($vin);

        // Припарковать авто
        $parking->park($vehicle);

        // Сохранить состояние
        $this->repo->save($parking);

        return $this->apiResponse->send($parking);
    }

    // Отпарковать авто
    public function unparkVehicle(int $parkingId, string $vin): array
    {
        // Загрузить парковку
        $parking = $this->repo->load($parkingId);

        // Отпарковать авто
        $parking->unpark($vin);

        // Сохранить состояние
        $this->repo->save($parking);

        return $this->apiResponse->send($parking);
    }

    // Удаление парковки
    public function removeParking(int $parkingId): array
    {
        // Загрузить объект парковки
        $parking = $this->repo->load($parkingId);

        // Удалить эту парковку
        $this->repo->removeParking($parkingId);

        return $this->apiResponse->send($parking);
    }
}