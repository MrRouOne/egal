<?php

namespace App\Rules;

use Egal\Validation\Rules\Rule as EgalRule;

class EndDateRule extends EgalRule
{

    /**
     * @param $attribute
     * @param $value
     * @param null $parameters
     * @return bool
     */
    public function validate($attribute, $value, $parameters = null): bool
    {
        $current_date = date("Y-m-d");
        return strtotime($current_date) < strtotime($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "The course has ended";
    }

}
