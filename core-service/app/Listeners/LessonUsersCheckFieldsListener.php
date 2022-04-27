<?php

namespace App\Listeners;

use App\Events\LessonUsersUpdatingEvent;
use App\Exceptions\ForbiddenFieldsException;
use App\Models\LessonUsers;
use Egal\Model\Exceptions\ObjectNotFoundException;

class LessonUsersCheckFieldsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * @param LessonUsersUpdatingEvent $event
     * @throws ForbiddenFieldsException
     * @throws ObjectNotFoundException
     */
    public function handle(LessonUsersUpdatingEvent $event): void
    {
        $attributes = $event->data->getAttributes();
        $lesson = LessonUsers::actionGetItem($attributes['id']);

        if ($attributes['user_id'] !== $lesson['user_id'] or $attributes['lesson_id'] !== $lesson['lesson_id']) {
            throw new ForbiddenFieldsException();
        }

    }
}
