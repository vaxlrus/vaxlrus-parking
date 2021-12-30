<?php

namespace App;

use App\Parking\Parking;

class ApiResponse
{
    private $apiResponse;

    public function __construct($apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }

    public function getData(): array
    {
        // Отправить ответ
        $result = null;

        // Если поступил объект
        if (is_object($this->apiResponse))
        {
            $result = $this->convertObjectToArray($this->apiResponse);
        }

        // Если поступил массив
        if (is_array($this->apiResponse))
        {
            $result = $this->convertArrayToArray($this->apiResponse);
        }

        // Отослать ответ
        return $result;
    }

    // Конвертирование объекта в представление
    private function convertObjectToArray(Parking $parking): array
    {
        $result = [];

        // Присвоение ID
        $result['id'] = $parking->getId();

        // Присвоение вместимости
        $result['capacity'] = $parking->getCapacity();

        // Список припаркованных авто
        $parkedCars = $parking->getParkedVehicles();

        // Присвоение парковочных мест
        if ($parkedCars > 0)
        {
            // Форммирование массива для авто
            $result['places'] = [];

            // Обработка каждого ТС на парковке
            foreach ($parking->getParkedVehicles() as $vehicle)
            {
                // Заполнение пространства парковки
                $result['places'][] = [
                    'type' => $vehicle->getVehicleType(),
                    'vin' => $vehicle->getVin(),
                ];
            }
        }

        // Вернуть удобно читаемый массив
        return $result;
    }

    // Конвертирование массива в представление
    // На вход поступает массив из объектов, в частности от метода loadParkins
    private function convertArrayToArray(array $parkingsList): array
    {
        // Результирующий массив
        $result = [];

        // Обработка каждого паркинга по очереди
        foreach ($parkingsList as $parking)
        {
            $result[] = $this->convertObjectToArray($parking);
        }

        // Вернуть список из удоюно читаемых представлений парковок
        return $result;
    }
}