<?php

namespace App\Listeners;

use App\Events\LessonUsersUpdatingEvent;
use App\Helpers\AbstractEvent;
use App\Helpers\AbstractListener;
use App\Helpers\ValidateHelper;
use App\Rules\CorrectUserIdRule;
use Egal\Model\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;

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

        $validate = new ValidateHelper;
        $validate->validate($attributes, [
            "user_id" => [new CorrectUserIdRule, 'required'],
        ]);
    }
}
