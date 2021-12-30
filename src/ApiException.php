<?php

namespace App;

use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use Throwable;

class ApiException extends \RuntimeException
{
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct("Ошибка API: " . $message, 0, $previous);
    }
}