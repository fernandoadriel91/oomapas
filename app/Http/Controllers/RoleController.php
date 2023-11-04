<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\Permission_Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    function __construct() {
        $this->middleware('ajax')->only(['datatable']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = PermissionController::getMenu();
        return view('role.index', ["role" =>new Role(), "menu" => $menu]);
    }

    public function datatable()
    {
        $p = $this->getPermission('role');
        $data = Role::with(['permissions' => function($q) {
            $q
                ->Where('c', '!=', false)
                ->orWhere('r', '!=', false)
                ->orWhere('u', '!=', false)
                ->orWhere('d', '!=', false)
                ->orWhere('admin', '!=', false);
            }])->get();
        if(isset($p))
            foreach($data as $d)
                $d['p'] = array('a'=>true,'e'=>$p->u,'d'=>$p->d);
        return datatables()->of($data)->toJson();
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
        $perm = array("_token"=>$data['_token'], "name"=>$data['name'], "state"=>$data['state'], "description"=>$data['description']);
        $id = Role::create($perm)->id;
        $r = $this->storeRolePermission($id, $data['_token'], $data['permisos']);
        return $data;
    }

    public function toggleActive(Role $role)
    {
        $active = $role->active > 0 ? 0 : 1;
        return (int) $role->update(["active"=>$active]);
    }

    private function storeRolePermission($id, $token, $permisos)
    {
        $r = 1;
        foreach ($permisos as $key => $value) {
           if(isset($value['permit']) && $value['permit'] == "on"){
                $data = array(
                    "_token"=>$token, 
                    "permission_id"=>(int)$value['id'],
                    "role_id"=>$id,
                    "c"=>(int)($value['C'] == "true"),
                    "r"=>(int)($value['R'] == "true"),
                    "u"=>(int)($value['U'] == "true"),
                    "d"=>(int)($value['D'] == "true"),
                    "admin"=>(int)($value['admin'] == "true"),
                );
                $r = Permission_Role::create($data);
                $permission = Permission::find((int)$value['id']);
                $this->createParent($permission->parent, $token, $id);
           }
        }
        return $r;
    }

    private function createParent($id_permission, $token, $id_role)
    {
        if ($id_permission == -1) {
            return;
        }
        $permission = Permission::find($id_permission);
        if (Permission_Role::where([['permission_id', $permission->id], ['role_id', $id_role]])->first()) {
            return ;
        }
        $data = array(
            "_token"=>$token,
            "permission_id"=>$permission->id,
            "role_id"=>$id_role,
            "c"=>0,
            "r"=>0,
            "u"=>0,
            "d"=>0,
            "admin"=>0,
        );
        Permission_Role::create($data);
        $this->createParent($permission->parent, $token, $id_role);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $role = Role::where('id', $role->id)->with('permissions')->get();
        return $role[0]->permissions;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::with('permissions')->where('id', $id)->firstOrFail();
        $menu = PermissionController::getMenu();
        return view('role.edit', ["role" => $role, "menu" => $menu]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $data = $request->all();
        Permission_Role::where('role_id', $role['id'])->delete();
        $r = $this->storeRolePermission($role['id'], $data['_token'], $data['permisos']);
        return (int)$role->update(array("_token"=>$data['_token'], "name"=>$data['name'], "state"=>$data['state'], "description"=>$data['description']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        return (int)$role->delete();
    }
}