<?php

namespace Smbear\RecordApiLogger\Exceptions;

use Exception;

class ConfigException extends Exception
{
    public function __construct(string $message = "",int $code = 500)
    {
        parent::__construct($message, $code);
    }
}