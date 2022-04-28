<?php

namespace App\Providers;

use App\Helpers\ModelManagerHelper;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * @package Egal\Model
 */
class DebugModelsServiceProvider extends IlluminateServiceProvider
{
    /**
     * Указывает, отложена ли загрузка провайдера.
     *
     * @noinspection PhpUnusedPropertyInspection
     * @var bool
     */
    protected bool $defer = true;

    /**
     * Команды для регистрации.
     *
     * @var array
     */
    protected array $commands = [];

    /**
     * @throws \Egal\Model\Exceptions\LoadModelImpossiblyException
     * @throws \ReflectionException
     */
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([]);
        }

        $this->app->singleton(ModelManagerHelper::class, function (): ModelManagerHelper {
            return new ModelManagerHelper();
        });

        ModelManagerHelper::loadModel(ModelManagerHelper::class);
        $this->commands([]);
    }

}
