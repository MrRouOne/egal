<?php

namespace App\Listeners;

use App\Exceptions\AlreadyCompleteException;
use App\Helpers\AbstractEvent;
use App\Helpers\AbstractListener;
use App\Helpers\ValidateHelper;
use App\Models\LessonUsers;
use App\Rules\IsPassedRule;
use Egal\Model\Exceptions\ValidateException;

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

        ValidateHelper::validate($attributes, [
            "is_passed" => [new IsPassedRule()],
        ]);

        if (LessonUsers::query()->findOrFail($attributes['id'])['is_passed']) {
            throw new AlreadyCompleteException();
        }
    }
}
