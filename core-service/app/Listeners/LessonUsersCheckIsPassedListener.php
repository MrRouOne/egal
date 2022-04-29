<?php

namespace App\Listeners;

use App\Events\LessonUsersUpdatingEvent;
use App\Exceptions\AlreadyCompleteException;
use App\Helpers\AbstractEvent;
use App\Helpers\AbstractListener;
use App\Helpers\ValidateHelper;
use App\Models\LessonUsers;
use App\Rules\IsPassedRule;
use Egal\Model\Exceptions\ObjectNotFoundException;
use Egal\Model\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;

class LessonUsersCheckIsPassedListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     * @throws AlreadyCompleteException
     * @throws ValidateException
     */
    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $attributes = $event->getModel()->getAttributes();

        $validate = new ValidateHelper;
        $validate->validate($attributes, [
            "is_passed" => [new IsPassedRule()],
        ]);

        if (LessonUsers::query()->find($attributes['id'])['is_passed']) {
            $exception = new AlreadyCompleteException();
            throw $exception;
        }
    }
}
