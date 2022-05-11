<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class IsPassedRule extends EgalRule
{

    /**
     * @param $attribute
     * @param $value
     * @param null $parameters
     * @return bool
     */
    public function validate($attribute, $value, $parameters = null): bool
    {
        return (bool) $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "The :attribute can't be false";
    }

}
