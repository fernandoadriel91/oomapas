<?php

namespace App\Observers;

use App\Traits\TracksHistoryTrait;
use Illuminate\Database\Eloquent\Model;

class RoleObserver
{
    use TracksHistoryTrait;

    protected $fields = array(
        "name" => "Nombre",
        "state" => "Estado Predeterminado",
        "description" => "Descripcion",
        "active" => "Estado"
    );

    public function created(Model $model)
    {
        $this->registry_created($model, "Fue creado");
    }
    
    public function updated(Model $model)
    {
        $this->track($model, function ($value, $field, $original) {
            return [
                'body' => "Se actualizo '{$this->fields[$field]}' de '${original}' a '${value}'",
            ];
        }, function($key) {
            return $this->fields[$key];
        });
    }
}