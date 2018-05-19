<?php

namespace App\Exceptions;

use Exception;

class InvalidConfirmationCodeException extends Exception
{
    public function __construct()
    {
        parent::__construct('InvalidConfirmationCodeException');
    }
}
