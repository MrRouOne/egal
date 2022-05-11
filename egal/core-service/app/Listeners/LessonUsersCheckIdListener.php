<?php

namespace App\Listeners;

use MrRouOne\Helpers\AbstractEvent;
use MrRouOne\Helpers\AbstractListener;
use MrRouOne\Helpers\ValidateHelper;
use App\Rules\CorrectUserIdRule;
use Egal\Model\Exceptions\ValidateException;

class LessonUsersCheckIdListener extends AbstractListener
{
    /**
     * @param AbstractEvent $event
     * @throws ValidateException
     */
    public function handle(AbstractEvent $event): void
    {
        parent::handle($event);
        $attributes = $event->getModel()->getAttributes();

        ValidateHelper::validate($attributes, [
            "user_id" => [new CorrectUserIdRule, 'required'],
        ]);
    }
}
