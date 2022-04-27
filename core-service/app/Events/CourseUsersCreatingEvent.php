<?php

namespace App\Events;

use App\Models\CourseUsers;
use Egal\Core\Events\Event;
use Illuminate\Queue\SerializesModels;

class CourseUsersCreatingEvent extends Event
{
    use SerializesModels;

    public $data;

    public function __construct(CourseUsers $data)
    {
        $this->data = $data;
    }

}
