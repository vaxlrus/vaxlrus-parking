<?php

namespace App;

use App\Parking\Parking;
use App\Repository;
use App\Parking\Vehicle;
use App\ApiException;

class Api
{
    private Repository $repo;

    public function __construct(Repository $repo)
    {
        $this->repo = $repo;
    }

    // Создание парковки
    public function createParking(int $capacity): ApiResponse
    {
        try {
            // Создать парковку
            $parking = new Parking($capacity, $this->repo->nextId());

            // Сохранить парковку в файл
            $this->repo->save($parking);
        } catch (\DomainException $error) {
            throw new \App\ApiException($error);
        }

        return new ApiResponse($parking);
    }

    // Получить все парковки
    public function getAllParkings(): ApiResponse
    {
        // Если ответ пустой или с ошибками по какой-то причине
        try {
            $result = $this->repo->loadAll();
        } catch (\DomainException $error) {
            throw new \App\ApiException($error);
        }

        return new ApiResponse($result);
    }

    // Получить конкретную парковку
    public function getParking(int $id): ApiResponse
    {
        try {
            $result = $this->repo->load($id);
        } catch (\DomainException $error) {
            throw new \App\ApiException($error);
        }

        return new ApiResponse($result);
    }

    // Запарковать авто
    public function parkVehicle(int $parkingId, string $vehicleType, string $vin): ApiResponse
    {
        try {
            // Загрузить объект парковки
            $parking = $this->repo->load($parkingId);

            // Если объект не является типом класса
            $classType = "App\\Parking\\{$vehicleType}";

            // Если переданный тип ТС не является дочерним классом абстрактного класса Vehicle, то выдать исключение
            if (!class_exists($classType) or !is_subclass_of($classType, Vehicle::class)) {
                throw new \DomainException('Объект типа ' . $vehicleType . ' не является транспортным средством');
            }

            // Создать тип транспортного средства
            $vehicle = new $classType($vin);

            // Припарковать авто
            $parking->park($vehicle);

            // Сохранить состояние
            $this->repo->save($parking);
        } catch (\DomainException $error) {
            throw new \App\ApiException($error);
        }

        return new ApiResponse($parking);
    }

    // Отпарковать авто
    public function unparkVehicle(int $parkingId, string $vin): ApiResponse
    {
        try {
            // Загрузить парковку
            $parking = $this->repo->load($parkingId);

            // Отпарковать авто
            $parking->unpark($vin);

            // Сохранить состояние
            $this->repo->save($parking);
        } catch (\DomainException $error) {
            throw new \App\ApiException($error);
        }

        return new ApiResponse($parking);
    }

    // Удаление парковки
    public function removeParking(int $parkingId): ApiResponse
    {
        try {
            // Загрузить объект парковки
            $parking = $this->repo->load($parkingId);

            // Удалить эту парковку
            $this->repo->removeParking($parkingId);
        } catch (\DomainException $error) {
            throw new \App\ApiException($error);
        }

        return new ApiResponse($parking);
    }
}