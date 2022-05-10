<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

abstract class AbstractListener
{
    public function handle(AbstractEvent $event): void
    {
        Log::info(sprintf("Listener [%s] event [%s]", get_class($this), get_class($event)));
    }
}
