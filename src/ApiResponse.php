<?php

namespace App;

use App\Parking\Parking;

class ApiResponse
{
    private $apiResponse;

    public function __construct($apiResponse)
    {
        $this->apiResponse = $apiResponse;

        // Отправить ответ
        $result = null;

        // Если поступил объект
        if (is_object($apiResponse))
        {
            $result = $this->convertObjectToArray($apiResponse);
        }

        // Если поступил массив
        if (is_array($apiResponse))
        {
            $result = $this->convertArrayToArray($apiResponse);
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