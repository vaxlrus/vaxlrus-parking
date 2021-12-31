<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Api;
use App\Repository;
use App\ApiException;

$api = new Api(new Repository(__DIR__ . '/configs'));

// Маршрутизация по методам
try {
    // -1 сам исключает файл вызова
    $argsCount = count($argv) - 1;

    if ($argsCount === 0 )
    {
        throw new Exception("Для работы программы требуется ввести аргументы");
    }

    // Исключить файл вызова
    array_shift($argv);

    // Метод
    $method = array_shift($argv);

    if (method_exists(App\Api::class, $method))
    {
        try {
            $response = call_user_func_array([$api, $method], $argv);
            echo json_encode($response->getData());
        }
        catch (ApiException $error)
        {
            echo $error->getMessage();
            exit();
        }
        catch (ArgumentCountError $error)
        {
            echo "Недостаточно аргументов для вызова функции";
        }
    }
    else
    {
        throw new Exception('Запрашиваемый метод не найден в API');
    }
}
catch (Throwable $error)
{
    echo $error->getMessage();
}

