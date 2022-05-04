<?php

namespace App\Helpers;

use Egal\Core\Events\Event;
use Egal\Model\Model;
use Illuminate\Support\Facades\Log;


abstract class AbstractEvent extends Event
{
    protected Model $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        Log::info(
            sprintf("Event [%s] was fired with model [%s]. [%s]. Serialized model [%s]", get_class($this), get_class($model),
                $model->wasChanged() ? "Changes: true" : "Dirty: true",
                empty($model->toArray()) ? "[]" : $model
            )
        );
        $this->setModel($model);
    }

    /**
     * @param Model $model
     */
    public function setModel(Model $model): void
    {
        $this->model = $model;
    }

    public function getModel(): Model
    {
        return $this->model;
    }
}
