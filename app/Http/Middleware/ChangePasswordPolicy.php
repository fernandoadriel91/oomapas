<?php

namespace App\Http\Middleware;

use Closure;

class ChangePasswordPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if (isset($user->change_password) && $user->change_password)
            return redirect()->route('password.renew');
        
        $dt = \Carbon\Carbon::createFromFormat('Y-m-d', $user->last_password_changed);
        if(isset($user->password_expires) && $user->password_expires && \Carbon\Carbon::now() > $dt->addDays(90))
            return redirect()->route('password.renew');

        return $next($request);
    }
}
