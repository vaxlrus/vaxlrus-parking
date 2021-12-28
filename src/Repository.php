<?php

namespace App;

use App\Parking\Parking;

class Repository
{
    // Путь для хранения файлов
    private string $path = __DIR__ . '/../configs/';

    // Сохранение парковки в файл
    public function save(Parking $parking): void
    {
        // Задать идентификатор для парковки
        $newId = $this->generateId();

        // Присвоить парковке этот ID
        $parking->setId($newId);

        // Строка с данными парковки
        $str = serialize($parking);

        // Идентификатор парковки
        $fileName = $this->path . '/' . $newId . '.txt';

        // Открытие файла хранилища
        $buffer = fopen($fileName, 'w+');

        // Заменить файл на новое состояние
        $state = fwrite($buffer, $str);

        // Если по каким-то причинам данные в файл не были записаны
        if (!$state)
        {
            throw new \DomainException('Невозможно записать данные в файл хранилища');
        }

        // Завершить работу с файлом
        fclose($buffer);
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
        $fileName = $this->path . $parkingId . '.txt';

        // Проверка на наличие файла
        if (!file_exists($fileName))
        {
            throw new \DomainException('Файл парковки с ID: ' . $parkingId . ' не найден');
        }

        // Открыть временно файл для чтения
        $state = file_get_contents($fileName);

        // Если по каким-то причинам файл не удалось открыть
        if (!$state)
        {
            throw new \DomainException('Не удалось открыть файл парковки');
        }

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
    private function generateId(): int
    {
        // Путь к файлу с хранилищем ID
        $idVault = $this->path . 'id.txt';

        // Если файл не существует
        if (!file_exists($idVault))
        {
            $lastId = 0;
        }
        // Если файл существует то нужно считать данные с него
        else
        {
            // Старое значение
            $lastId = file_get_contents($idVault);

            // Инкрементировать новое значение
            $lastId++;
        }

        // Так как файла не существует или если существует, то все равно на перезапись, флаг "с" создаст его или откроет
        $stream = fopen($idVault, 'w+');

        // Заменить файл на новое состояние
        $state = fwrite($stream, $lastId);

        // Если по каким-то причинам данные в файл не были записаны
        if (!$state)
        {
            throw new \DomainException('Невозможно записать данные в файл хранилища');
        }

        // Завершить работу с файлом
        fclose($stream);

        return $lastId;
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
        unlink($this->path . $parkingId . '.txt');
    }
}