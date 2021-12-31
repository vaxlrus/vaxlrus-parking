<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Api;
use App\Repository;
use App\Throwable;
use App\ApiException;

$api = new Api(new Repository(__DIR__ . '/configs'));

// Все доступные методы API
$methods_list = get_class_methods(Api::class);

// Удалить из списка __construct
unset($methods_list[array_search('__construct', $methods_list)]);

// -1 сам исключает файл вызова
$argsCount = count($argv) - 1;

// Если аргументов нет, то продолжать нет смысла
if ($argsCount === 0 )
{
    throw new Throwable("Для работы программы требуется ввести аргументы");
}
else
{
    // Исключить файл вызова
    array_shift($argv);
}

// Вызываемый метод
$needle_method = array_shift($argv);

// Маршрутизация по методам
foreach ($methods_list as $method)
{
    // Если не найден запрашиваемый метод среди доступных
    if ($method === $needle_method)
    {
        try
        {
            $response = call_user_func_array(array($api, $needle_method), $argv);
            var_dump(json_encode($response->getData()));
            exit();
        }
        catch (ApiException $error)
        {
            echo $error->getMessage();
            exit();
        }
    }
}

throw new Throwable('Запрашиваемый метод не найден в API');