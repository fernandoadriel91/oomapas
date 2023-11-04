<?php

namespace App\Observers;

use App\Traits\TracksHistoryTrait;
use Illuminate\Database\Eloquent\Model;
use App\Role;

class UserObserver
{
    use TracksHistoryTrait;

    protected $fields = array(
        "name" => "Nombre",
        "username" => "Usuario",
        "email" => "Correo",
        "role_id" => "Rol",
        "active" => "Estado",
        "password" => "Contraseña"
    );

    protected $ignored_fields = array(
        "created_at", "updated_at", "remember_token", "last_login", "change_password", "last_password_changed", "password_expires", "timeout"
    );

    public function creating(Model $model)
    {
        $model->last_password_changed = \Carbon\Carbon::now();
    }

    public function created(Model $model)
    {
        $this->registry_created($model, "Fue creado");
    }

    public function updating(Model $model)
    {
        $ignore = $this->ignored_fields;
        $fields = collect($model->getDirty())->filter(function ($value, $key) use ($ignore) {
            return !in_array($key, $ignore);
        });
        foreach ($fields as $key => $value) {
            if($key == 'password') {
                $model->last_password_changed = \Carbon\Carbon::now();
            }
        }
    }
    
    public function updated(Model $model)
    {
        
        
        
        $this->track($model, function ($value, $field, $original) {
            switch ($field) {
                case 'role_id':
                    $role = Role::findOrFail($value);
                    $value = $role->name;
                    $role = Role::findOrFail($original);
                    $original =  $role->name;
                    break;
                case 'active':
                    $value = $value == 1 ? "Activo" : "Inactivo";
                    $original = $original == 1 ? "Activo" : "Inactivo";
                    break;
                default:
                    break;
            }

            if($field == "password")
                return [
                    'body' => "Se cambio la contraseña",
                ];

            return [
                'body' => "Se actualizo '{$this->fields[$field]}' de '${original}' a '${value}'",
            ];
        }, function($key) {
            return $this->fields[$key];
        }, null, null, $this->ignored_fields);
    }
}