<?php

namespace App\Listeners;

// неиспользуемые import
use App\Events\LessonUsersUpdatingEvent;
use App\Exceptions\ForbiddenFieldsException;
use App\Helpers\AbstractEvent;
use App\Helpers\AbstractListener;
use App\Models\LessonUsers;
use Egal\Model\Exceptions\ObjectNotFoundException;

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
        // упадет если нет lesson
        $lesson = LessonUsers::query()->find($attributes['id']);

        if ($attributes['user_id'] !== $lesson['user_id'] or $attributes['lesson_id'] !== $lesson['lesson_id']) {
            throw new ForbiddenFieldsException();
        }
// лишний отступ
    }
}
