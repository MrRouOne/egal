<?php

namespace App\Providers;

use App\Events\CourseUsersCreatedEvent;
use App\Events\LessonUsersUpdatedEvent;
use App\Events\LessonUsersUpdatingEvent;
use App\Listeners\CourseUsersCheckCapacityListener;
use App\Listeners\CourseUsersRecordToLessonsListener;
use App\Listeners\CourseUsersUpdateCapacityListener;
use App\Listeners\CourseUsersValidateUniqueListener;
use App\Listeners\LessonUsersCheckFieldsListener;
use App\Listeners\LessonUsersCheckFinishCourseListener;
use App\Listeners\LessonUsersCheckIdListener;
use App\Listeners\LessonUsersCheckIsPassedListener;
use App\Listeners\LessonUsersUpdatePercentListener;
use Egal\Core\Events\EventServiceProvider as ServiceProvider;
use App\Listeners\CourseUsersCheckIdListener;
use App\Events\CourseUsersCreatingEvent;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CourseUsersCreatingEvent::class => [
            CourseUsersValidateUniqueListener::class,
            CourseUsersCheckIdListener::class,
            CourseUsersCheckCapacityListener::class,
        ],
        CourseUsersCreatedEvent::class => [
            CourseUsersUpdateCapacityListener::class,
            CourseUsersRecordToLessonsListener::class,
        ],
        LessonUsersUpdatingEvent::class => [
            LessonUsersCheckIdListener::class,
            LessonUsersCheckFinishCourseListener::class,
            LessonUsersCheckIsPassedListener::class,
            LessonUsersCheckFieldsListener::class,
        ],
        LessonUsersUpdatedEvent::class => [
            LessonUsersUpdatePercentListener::class,
        ],
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }

}
