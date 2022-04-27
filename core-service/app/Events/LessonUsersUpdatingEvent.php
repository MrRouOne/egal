<?php

namespace App\Events;

use App\Models\LessonUsers;
use Egal\Core\Events\Event;
use Illuminate\Queue\SerializesModels;

class LessonUsersUpdatingEvent extends Event
{
    use SerializesModels;

    public $data;

    public function __construct(LessonUsers $data)
    {
        $this->data = $data;
    }

}
