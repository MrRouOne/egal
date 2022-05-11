<?php

namespace App\Exceptions;

use Exception;

class AlreadyCompleteException extends Exception
{
    protected $message = 'You have already completed this lesson!';
    protected $code = 400;
}
