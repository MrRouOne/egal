<?php

namespace App\Helpers;

abstract class Session
{
    public static function getAttributes()
    {
        return \Egal\Core\Session\Session::getActionMessage()->getParameters()['attributes'];
    }
}
