<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permission.index');
    }

    public function getRolePermission()
    {
        $child = $this->getMenu();
        return view('partial.role_menu_partial', compact('child'));
    }

    public function getMenuBuilder()
    {
        $menu = $this->getMenu();
        return view('partial.menu_builder_partial', compact('menu'));
    }

    public static function getMenu()
    {
        $child = Permission::where('parent', '-1')->orderBy('priority', 'ASC')->with('childs')->get();
        $child = array("childs" => $child);
        return $child;
    }

    public function icons(Request $request)
    {
        $path = storage_path() . "/app/json/icons.json";
        $arr = json_decode(file_get_contents($path), true); 

        $searchArr = explode(' ', $request->input('query'));
        $result = array();
        foreach ($arr as $value) {
            $r = array();
            foreach ($searchArr as $query) {
                $r = array_merge($r, $this->search($value['children'], $query));
            }
            if (!empty($r))
                array_push($result, array("text"=>$value['text'], "children"=>$r));
        }
        return response()->json($result);
    }

    function search($array, $query)
    {
        $results = array_filter(
            $array, function ($item) use ($query) {
                $i = strpos($item['text'], $query);
                $i = $i === 0 ? true : $i;
                return $i;
            }
        );
        return $results;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Permission::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $permission = Permission::findOrFail($request['id']);
        return (int)$permission->update($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        return (int)$permission->update($request->all());
    }

    public function updatePriority(Request $request)
    {
        return $this->editPriority($request->menu);
    }

    private function editPriority($values, $parent = -1)
    {
        $r = 1;
        foreach ($values as $key => $value) {
            $permission = Permission::findOrFail($value['id']);
            $r = (int)$permission->update(['priority'=>$key+1, 'parent'=>$parent]);
            if(isset($value['children']))
                $r =  $this->editPriority($value['children'], $value['id']);
        }
        return $r;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        return (int)$permission->delete();
    }
}
