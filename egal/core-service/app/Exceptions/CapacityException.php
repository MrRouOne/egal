<?php

namespace App\Exceptions;

use Exception;

class CapacityException extends Exception
{
    protected $message = 'There are no available places on this course!';
    protected $code = 400;
}
