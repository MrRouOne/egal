<?php

namespace App\Events;

use App\Helpers\AbstractEvent;
use App\Models\LessonUsers;
use Egal\Core\Events\Event;
use Illuminate\Queue\SerializesModels;

class LessonUsersUpdatingEvent extends AbstractEvent
{
    /**
     * @param LessonUsers $data
     */
    public function __construct(LessonUsers $data)
    {
        parent::__construct($data);
    }
}
