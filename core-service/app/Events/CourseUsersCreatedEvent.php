<?php

namespace App\Events;

use App\Models\CourseUsers;
use App\Models\User;
use Egal\Core\Events\Event;
use Illuminate\Queue\SerializesModels;

class CourseUsersCreatedEvent extends Event
{
    use SerializesModels;

    public $data;

    public function __construct(CourseUsers $data)
    {
        $this->data = $data;
    }


}
