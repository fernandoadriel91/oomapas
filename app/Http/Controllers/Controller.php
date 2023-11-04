<?php

namespace App\Http\Controllers;

use Auth;
use App\Permission_Role;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getPermission($r)
    {
        $this->r = $r;
        $permissions = Permission_Role::
        with(['permission'=> function ($q)
        {
            $q->where('route',$this->r);
        }])
        ->where('role_id',Auth::user()->role_id)
        ->get();
        $crud = $permissions->where('permission','!=',null)->first();  
        return $crud;
    }
}
