<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Carbon\Carbon;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/Admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $r = $request->all();
        $r['remember'] = isset($r['remember']) ? true : false;

        $user = User::where('email', $r['username'].$r['company'])->first();
        if (!$user || !Hash::check($r['password'], $user->password)) {
            return response()->json([
                'msg' => "Usuario o contraseña invalidos"
            ], 422);
        }  
        if($user->active != 1)
        {
            return response()->json([
                'msg' => "Usuario desactivado"
            ], 422);
        }
        $user->update(array("last_login"=>Carbon::now()));
        Auth::login($user, $r['remember']);
    }   

    public function showLoginForm()
    {
        return view('auth.login-3');
    }
}
