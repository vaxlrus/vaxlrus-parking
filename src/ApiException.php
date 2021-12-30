<?php

namespace App;

use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use Throwable;

class ApiException extends \RuntimeException
{
    public function __construct(Throwable $error)
    {
        parent::__construct("Ошибка API: " . $error->getMessage(), 0, $error);
    }
}