<?php

namespace App\Http\Middleware;


use Closure;
use Auth;
use App\User;
use App\Permission_Role;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PermissionCheck
{
    private $route;

    public function __construct(Route $route) {
        $this->route = $route;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
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
        $permission = $p->where('permission','!=',null)->first();
        if($permission == null ||
            ($request->isMethod('GET') && !$permission->r) || ($request->isMethod('POST') && !$permission->c) ||
            ($request->isMethod('PUT') && !$permission->u) || ($request->isMethod('DELETE') && !$permission->d)
        )
            return response()->view('errors.unauthorized', [], 200);


        return $next($request);
    }
}