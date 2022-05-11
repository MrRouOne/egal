<?php

namespace App\Exceptions;

use Exception;

class IncorrectPasswordException extends Exception
{
    protected $message = 'Incorrect password!';
    protected $code = 400;
}
