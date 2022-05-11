<?php

namespace MrRouOne\Helpers;

use Egal\Model\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;

class ValidateHelper
{
    /**
     * @param array $attributes
     * @param array $rules
     * @throws ValidateException
     */
    public static function validate(array $attributes, array $rules)
    {
        $validator = Validator::make($attributes, $rules);

        if ($validator->fails()) {
            $exception = new ValidateException();
            $exception->setMessageBag($validator->errors());

            throw $exception;
        }
    }
}
