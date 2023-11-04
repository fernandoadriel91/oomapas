<?php

namespace App\Http\ViewComposers;

use Auth;
use App\User;
use App\Permission_Role;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PermissionsComposer
{
    /*
    * Create a movie composer.
    *
    * @return void
    */
    protected $permission;

    public function __construct()
    {
        $p = Permission_Role::
        with(['permission'=> function ($q)
        {
            $route = Route::currentRouteName();
            $route = explode('.', $route)[0];
            $q->where('route',$route);
        }])
        ->where('role_id',Auth::user()->role_id)
        ->get();
        $this->permission = $p->where('permission','!=',null)->first();
        
    }
    
    /**
    * Bind data to the view.
    *
    * @param  View  $view
    * @return void
    */
    public function compose(View $view)
    {
        $view->with('permission', $this->permission);
    }
}