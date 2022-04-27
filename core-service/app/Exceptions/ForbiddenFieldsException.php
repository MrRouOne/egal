<?php

namespace App\Exceptions;

use Exception;

class ForbiddenFieldsException extends Exception
{
    protected $message = 'Invalid fields were passed!';
    protected $code = 405;
}
