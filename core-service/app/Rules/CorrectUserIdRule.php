<?php

namespace App\Rules;

use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;

class CorrectUserIdRule extends EgalRule
{
    /**
     * @param $attribute
     * @param $value
     * @param null $parameters
     * @return bool
     */
    public function validate($attribute, $value, $parameters = null): bool
    {
        return $value === Session::getUserServiceToken()->getUid();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "The :attribute does not match your id";
    }
}
