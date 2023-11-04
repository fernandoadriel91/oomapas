<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Role;
use App\Permission;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = array("childs" =>$this->menus());
        $menu = compact('menu');
        return view('index', $menu);
    }

    public function checkSession()
    {
        return Auth::check() ? response()->json(array("auth"=>true)) : response()->json(array("auth"=>false));
    }

    public function notfound()
    {
        return view('errors.404');
    }

    public function cacheBuster(Request $request)
    {
        $files = $request->input('files');
        $retval = $this->get($files['css']);
        return response()->json($retval);
    }

    public function breadcrumbs(Request $request)
    {
        $data = $request->input('data');
        return view('partial.breadcrumbs', compact('data'));
    }

    public function defaultState()
    {
        $role = Role::find(Auth::user()['role_id']);
        return response()->json($role->state);
    }

    private function menus($parent = -1)
    {
        Auth::user();
        $role = Role::find(Auth::user()['role_id']);
        $nonMenu = Permission::where('parent', $parent)->where('menu', 0)->get();
        $permissions = $role->permissions()->where('parent', $parent)->get()->merge($nonMenu);
        $permissions = array_values(Arr::sort($permissions, function ($value) {
        //$permissions = array_values(array_sort($permissions, function ($value) {
            return $value['priority'];
        }));
        
        foreach ($permissions as $key => $value) {
            $permissions[$key]['childs'] = $this->menus($value['id']);
        }
        return $permissions;
    }

    private function getTime($file)
    {
        $tmpFile = dirname(dirname(dirname(__FILE__)))."/".$file;
        if (file_exists(public_path($file))) {    
            return array("url"=>$file, "time"=>filemtime(public_path($file)));
        } else {
            return array("url"=>$file);
        }
    }

    private function get($bundle)
    {
        $ret = array();
        foreach ($bundle as $value) {
            if(is_array($value))
                continue;
            array_push($ret, $this->getTime($value));
        }
        return $ret;
    }
   
}
