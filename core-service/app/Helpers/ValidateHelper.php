<?php

namespace App\Helpers;

use Egal\Model\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;

class ValidateHelper
{
    protected array $attributes;
    protected array $rules;

    public function __construct(array $attributes, array $rules)
    {
        $this->attributes = $attributes;
        $this->rules = $rules;
    }

    /**
     * @throws ValidateException
     */
    public function validate()
    {
        $validator = Validator::make($this->attributes, $this->rules);

        if ($validator->fails()) {
            $exception = new ValidateException();
            $exception->setMessageBag($validator->errors());

            throw $exception;
        }
    }
}
