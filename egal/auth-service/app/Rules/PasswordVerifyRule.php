<?php

namespace App\Rules;

use App\Models\User;
use Egal\Core\Session\Session;
use Egal\Validation\Rules\Rule as EgalRule;

class PasswordVerifyRule extends EgalRule
{
    /**
     * @param $attribute
     * @param $value
     * @param null $parameters
     * @return bool
     */
    public function validate($attribute, $value, $parameters = null): bool
    {
        $email = Session::getActionMessage()->getParameters()['email'];
        $user = User::query()->where('email', '=', $email)->first();
        if (!$user) {
            return false;
        }
        return password_verify($value, $user->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "The :attribute incorrect";
    }

}
