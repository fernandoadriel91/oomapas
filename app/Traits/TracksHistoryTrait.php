<?php 

namespace App\Traits;

use Auth;
use Illuminate\Database\Eloquent\Model;
use App\History;

trait TracksHistoryTrait
{
    protected function registry_created(Model $model, $body = null, $table = null, $id = null) {
        $table = $table ?: $model->getTable();
        $id = $id ?: $model->id;
        $body = $body ?: "Created";

        History::create([
            'reference_table'   => $table,
            'reference_id'      => $id,
            'user_id'           => Auth::user()->id,
            'body'              => $body
        ]);
    }

    protected function track(Model $model, callable $func = null, callable $map_func = null, $table = null, $id = null, $ignore = ['created_at', 'updated_at'])
    {
        $table = $table ?: $model->getTable();
        $id = $id ?: $model->id;
        $func = $func ?: [$this, 'getHistoryBody'];
        $map_func = $map_func ?: [$this, 'map'];
        $this->getUpdated($model, $ignore)
            ->map(function ($value, $field) use ($func, $model) {
                return call_user_func_array($func, [$value, $field, $model->getOriginal($field)]) + [ 
                    'reference_field'   => $field,
                    'old_value'         => $model->getOriginal($field)
                ];
            })
            ->mapWithKeys(function ($value, $key) use ($map_func) {
                return [call_user_func_array($map_func, [$key]) => $value];
            })
            ->each(function ($fields) use ($table, $id, $model) {
                History::create([
                    'reference_table'   => $table,
                    'reference_id'      => $id,
                    'user_id'           => Auth::user()->id ?? 1
                ] + $fields);
            });
    }

    protected function map($key)
    {
        return str_replace('_', ' ', $key);
    }

    protected function getHistoryBody($value, $field)
    {
        return [
            'body' => "Updated {$field} to ${value}",
        ];
    }

    protected function getUpdated($model, $ignore)
    {
        return collect($model->getDirty())->filter(function ($value, $key) use ($ignore) {
            return !in_array($key, $ignore);
        });
    }
}