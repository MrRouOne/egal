<?php

namespace App\Listeners;

use App\Events\CreateUserEvent;
use Egal\Core\Exceptions\RequestException;
use Egal\Core\Listeners\GlobalEventListener;
use Egal\Core\Listeners\EventListener;

class CreateUserListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param CreateUserEvent $event
     */
    public function handle(CreateUserEvent $event): void
    {
        var_dump("GG");
        die();
//        $request = new \Egal\Core\Communication\Request(
//            'core', // Сервис назначения запроса
//            'Users', // К какой модели обращение
//            'create', // К какому действию обращение
//            [
//                "phone" => $event['phone']
//            ]);
    }

}
