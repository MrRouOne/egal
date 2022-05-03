<?php

namespace App\Helpers;

use Egal\Core\Events\Event;
use Egal\Core\Session\Session;
use Egal\Model\Model;
use Illuminate\Support\Facades\Log;


abstract class AbstractEvent extends Event
{
    // лучше protected
    private Model $model;

    public function __construct(Model $model)
    {
        // Используй функцию sprintf или vsprintf для форматированного  вывода строки
        // changed и dirty взаимоисключающие состояния модели, одновременно будет заполнено или первое или второе, выводим не пустой массив атрибутов
        Log::info(
            'Event ' . get_class($this)
            . ' was fired with model: '
            . get_class($model)
            . '(Changes: ' . $model->wasChanged()
            . ', Dirty: ' . $model->isDirty()
            . ") \nSerialized model: "
            , [$model->toArray()]
        );
        $this->setModel($model);
    }

    // указать возвращаемый тип
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

}
// лишний отступ
