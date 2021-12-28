<?php

namespace App;

use App\Parking\Parking;

class Repository
{
    private string $path;
    private string $vaultName = 'id.txt';

    public function __construct(string $configPath)
    {
        $this->path = $configPath;
    }

    // Сохранение парковки в файл
    public function save(Parking $parking): void
    {
        // Строка с данными парковки
        $str = serialize($parking);

        // Идентификатор парковки
        $fileName = $this->path . '/' . $parking->getId() . '.txt';

        // Записать данные в файл
        file_put_contents($fileName, $str);
    }

    // Получение парковки из файла
    public function load(int $parkingId): Parking
    {
        // Если передан не правильного формата ИД
        if ($parkingId < 0)
        {
            throw new \DomainException('Идентификатор парковки не может быть отрицательным');
        }

        // Путь к файлу
        $fileName = $this->path . '/' . $parkingId . '.txt';

        // Проверка на наличие файла
        if (!file_exists($fileName))
        {
            throw new \DomainException('Файл парковки с ID: ' . $parkingId . ' не найден');
        }

        // Открыть временно файл для чтения
        $state = file_get_contents($fileName);

        // Вернуть файл в человеко-читаемый вид
        return unserialize($state);
    }

    // Метод загрузки всех парковок разом
    public function loadAll(): array
    {
        // Существующие парковки
        $existParkings = $this->getExistParkings();

        // Временное хранилище для всех объектов
        $arrayBuffer = [];

        // Обработка папки и десерализация данных
        foreach ($existParkings as $parkingId)
        {
            $arrayBuffer[] = $this->load($parkingId);
        }

        // Возврат временного буфера
        return $arrayBuffer;
    }

    // Генератор названий файлов
    // TODO: добавить проверку на список файлов ибо в id.txt может быть "2", а в каталоге пусто, нужно сбросить состояние
    public function nextId(): int
    {
        // Путь к файлу с хранилищем ID
        $idVault = $this->path . '/'. $this->vaultName;

        // Если файл не существует
        if (!file_exists($idVault))
        {
            $nextId = 0;
        }
        // Если файл существует то нужно считать данные с него
        else
        {
            // Старое значение
            $nextId = file_get_contents($idVault) + 1;
        }

        return $nextId;
    }

    // Получение списка файлов из папки хранилища
    private function getExistParkings(): array
    {
        // Получить список всех файлов в папке хранилища
        $files = scandir($this->path);

        // Результирующий массив
        $result = [];

        // Если файл содержит расширение txt то добавляется в результирующий массив
        foreach ($files as $key => $item)
        {
            // Если файл соответствует правилу <число>.txt
            if (preg_match('/(\d+).txt/', $item, $match))
            {
                // Обрезать у итого файла
                $result[] = intval($match[1]);
            }
        }

        return $result;
    }

    // Удаление парковки
    public function removeParking(int $parkingId): void
    {
        // Если парковки для удаления не существует в хранилище
        if (!in_array($parkingId, $this->getExistParkings()))
        {
            throw new \DomainException('Парковки с ID: ' . $parkingId . ' не существует');
        }

        // Удалить файл
        unlink($this->path . '/' . $parkingId . '.txt');
    }
}