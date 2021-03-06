<?php

namespace App\Parking;

class Parking
{
    private int $totalCapacity; // Общая вместимость паркинга
    private array $carStorage = []; // Хранилище автомобилей
    private int $id; // Идентификатор парковки

    public function __construct(int $totalCapacity, int $id)
    {
        // Проверка идентификатора парковки
        if ($id < 0)
        {
            throw new \DomainException('Идентификатор не может быть отрицательным');
        }

        // Если парковка создается с нулевым или отрицательным пространством
        if ($totalCapacity <= 0)
        {
            throw new \DomainException('Вместимость парковки может иметь только положительное значение');
        }

        // Задать вместимость парковки
        $this->totalCapacity = $totalCapacity;

        // Задать идентификатор
        $this->id = $id;
    }

    // Парковка авто
    public function park(Vehicle $vehicle): void
    {
        // Если количество занятых мест равно максимальному на парковке, то она переполнена: return false
        if ($this->getFreeSpaceCount() === 0.0)
        {
            throw new \DomainException('Парковка переполнена');
        }

        // Если на парковке уже существует авто с vin номер автомобиля который пытается запарковаться
        if ($this->assertVinIsExist($vehicle->getVin()))
        {
            throw new \DomainException('На парковке уже существует авто с VIN номером вашего транспортного средства. Парковка запрещена');
        }

        // Добавить авто на парковку
        $this->carStorage[] = $vehicle;
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
        foreach ($this->carStorage as $key => $vehicle)
        {
            // Если вин номер автомобиля с парковки совпадает с переданным в метод
            if ($vehicle->getVin() === $vin)
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
    public function getFreeSpaceCount(): float
    {
        // Посчитать суммарное количество занимаемых мест всеми ТС
        $totalCount = 0.0;

        foreach ($this->carStorage as $vehicle)
        {
            $totalCount += $vehicle->getSize();
        }

        // Вернуть разница между общим количествм мест и занимаемым в данный момент
        return (float) $this->totalCapacity - (float) $totalCount;
    }

    // Получение вместимости парковки
    public function getCapacity(): int
    {
        return $this->totalCapacity;
    }

    // Получить идентификатор парковки
    public function getId(): int
    {
        return $this->id;
    }

    // Получить список припаркованных ТС
    public function getParkedVehicles(): array
    {
        return $this->carStorage;
    }
}