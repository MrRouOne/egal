<?php

namespace App\Rules;

use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;

class ForbiddenFieldRule extends EgalRule
{

    public function validate($attribute, $value, $parameters = null): bool
    {
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "The :attribute unavailable for update";
    }

}
