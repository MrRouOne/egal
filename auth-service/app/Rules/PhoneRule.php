<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class PhoneRule extends EgalRule
{
    /**
     * @param $attribute
     * @param $value
     * @param null $parameters
     * @return bool
     */
    public function validate($attribute, $value, $parameters = null): bool
    {
        return strlen($value) >= 10 and preg_match('/^\+?[1-9]{1}\(?[0-9]{3}\)?[0-9]{3}-[0-9]{2}-[0-9]{2}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "The :attribute must be like '+X(XXX)XXX-XX-XX'.";
    }

}
