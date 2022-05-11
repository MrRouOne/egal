<?php

namespace App\Listeners;

use App\Exceptions\ForbiddenFieldsException;
use MrRouOne\Helpers\AbstractEvent;
use MrRouOne\Helpers\AbstractListener;
use App\Models\LessonUsers;

class LessonUsersCheckFieldsListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     * @throws ForbiddenFieldsException
     */
    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $attributes = $event->getModel()->getAttributes();
        $lesson = LessonUsers::query()->findOrFail($attributes['id']);

        if ($attributes['user_id'] !== $lesson['user_id'] or $attributes['lesson_id'] !== $lesson['lesson_id']) {
            throw new ForbiddenFieldsException();
        }
    }
}
