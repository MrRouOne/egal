<?php

namespace App\Providers;

use App\Listeners\RegisterUserListener;
use Egal\Core\Events\EventServiceProvider as ServiceProvider;
use App\Events\CreateUserEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CreateUserEvent::class => [
            RegisterUserListener::class
        ],
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }

}
