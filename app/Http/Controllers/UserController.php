<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use App\PasswordHistory;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    
    function __construct() {
        $this->middleware('ajax')->only(['datatable', 'userexists']);
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('user.index', [ 'user'=>new User() ]);
    }

    public function userexists(Request $request)
    {   
        $user = $request->input('username').$request->input('company');
        $before = $request->input('before').$request->input('company');
        $valid = isset($before) && $before === $user;
        $data = User::where('email', $user)->first();
        return $data && !$valid ? "false" : "true";
    } 

    public function change_password(Request $request)
    {
        if($request->ajax()){
            return view('user.change_password');
        }

        if (isset(Auth::user()->change_password) && Auth::user()->change_password)
            return view('user.renew',[ "message" => "Por su seguridad debe cambiar obligatoriamente su contraseña." ]);

        $dt = \Carbon\Carbon::createFromFormat('Y-m-d', Auth::user()->last_password_changed);
        if(isset(Auth::user()->password_expires) && Auth::user()->password_expires && \Carbon\Carbon::now() >= $dt->addDays(90))
            return view('user.renew', [ "message" => "Han pasado al menos 90 dias desde que cambiaste tu contraseña, por seguridad debes ingresar una nueva." ]);
        
        return view('errors.unauthorized');
    }

    public function update_password(Request $request)
    {
        $user = Auth::user();
        $password = $request->input('password');
        if($this->testPassword($password)) {
            $r = (int) $user->update([
                'password'=>$password,
                'change_password'=> false
            ]);
            PasswordHistory::create([
                'user_id' => $user->id,
                'password' => $user->password
            ]);
            return $r;
        }

        return response()->json(["Error"=>"No puede utilizar una contraseña que haya usado anteriormente."], 422);
    }

    public function toggleActive(User $user)
    {
        $active = $user->active > 0 ? 0 : 1;
        return (int) $user->update(["active"=>$active]);
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['email'] = $data['username'].$data['company'];
        $data['change_password'] = $data['change_password'] && $data['change_password'] == 'on' ? 1 : 0;
        $data['password_expires'] = $data['password_expires'] && $data['password_expires'] == 'on' ? 1 : 0;
        return User::create($data);
    }
    
    public function datatable()
    {
        $p = $this->getPermission('user');
        $data = User::with(['role', 'dependency', 'department'])->get();
        if(isset($p))
            foreach($data as $d)
                $d['p'] = array('a'=>true && $p->u,'e'=>$p->u,'d'=>$p->d);
        return datatables()->of($data)->toJson();
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, User $user)
    {
        $data = $request->all();
        if(isset($data['password']))
            $user->update(
                [
                    'password'=>$data['password'],
                    'change_password' => true
                ]);
        return (int)$user->update([
            'username'=>$data['username'], 
            'name'=>$data['name'],
            'email'=>$data['username'].$data['company'],
            'dependency_id'=>$data['dependency_id'],
            'department_id'=>$data['department_id'],
            'role_id'=>$data['role_id'],
            'change_password' => isset($data['change_password']) && $data['change_password'] == 'on' ? true : false,
            'password_expires' => isset($data['password_expires']) && $data['password_expires'] == 'on' ? true : false
        ]);
    }

    private function testPassword($password)
    {
        foreach (Auth::user()->passwords as $value)
            if(Hash::check($password, $value->password))
                return false;
        return true;
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(User $user)
    {
        return (int)$user->delete();
    }
}