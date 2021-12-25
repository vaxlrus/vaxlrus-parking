<?php

namespace App;

class Parking
{
    private int $totalCapacity; // Общая вместимость паркинга
    private array $carStorage = []; // Хранилище автомобилей

    public function __construct(int $totalCapacity)
    {
        // Если парковка создается с нулевым пространством
        if ($totalCapacity == 0)
        {
            throw new \DomainException('Парковка не может быть создана без мест');
        }

        // Если парковка создается с отрицательным пространством
        if ($totalCapacity < 0)
        {
            throw new \DomainException('Парковка не может иметь отрицательную вместимость');
        }

        // Задать вместимость парковки
        $this->totalCapacity = $totalCapacity;
    }

    // Парковка авто
    public function park(Vehicle $auto): void
    {
        // Если количество занятых мест равно максимальному на парковке, то она переполнена: return false
        if (count($this->carStorage) === $this->totalCapacity)
        {
            throw new \DomainException('Парковка переполнена');
        }

        // Если на парковке уже существует авто с vin номер автомобиля который пытается запарковаться
        if ($this->assertVinIsExist($auto->getVin()))
        {
            throw new \DomainException('На парковке уже существует авто с VIN номером вашего транспортного средства. Парковка запрещена');
        }

        // Добавить авто на парковку
        $this->carStorage[] = $auto;
    }

    // Отпарковка авто
    public function unpark(string $vin): void
    {
        // Если на парковке автомобиль так и не был найден, то выбросить исключение
        if (!$this->assertVinIsExist($vin))
        {
            throw new \DomainException('Транспортное средство не найдено на парковке');
        }

        // Если автомобиль с указанным ВИН номером существует на парковке, то отпарковать его
        foreach ($this->carStorage as $key => $auto)
        {
            // Если вин номер автомобиля с парковки совпадает с переданным в метод
            if ($auto->getVin() === $vin)
            {
                // То удалить автомобиль с парковки
                unset($this->carStorage[$key]);
            }
        }
    }

    // Проверка на наличие автомобиля по вин номеру
    private function assertVinIsExist(string $vin): bool
    {
        // Найти автомобиль по вин номеру
        foreach ($this->carStorage as $key => $auto)
        {
            // Если вин номер запроса является вин номером автомобиля с парковки, то вернуть положительный результат
            if ($auto->getVin() === $vin)
            {
                return true;
            }
        }

        // Если на парковке не был найден автомобиль с указанным VIN значит такого нет
        return false;
    }

    // Определение количества свободных мест
    public function getFreeSpaceCount(): int
    {
        return $this->totalCapacity - count($this->carStorage);
    }
}