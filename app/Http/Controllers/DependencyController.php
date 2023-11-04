<?php

namespace App\Http\Controllers;

use App\Dependency;
use Illuminate\Http\Request;

class DependencyController extends Controller
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
        return view('dependency.index', ["dependency" => new Dependency()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Dependency::create($request->all());
    }

    public function datatable()
    {
        $p = $this->getPermission('dependency');
        $data = Dependency::query();
        return datatables()->of($data)
        ->addColumn('p', function() use($p) {
            return [ 'a'=>false,'e'=>$p->u ?? false,'d'=>$p->d ?? false ];
        })
            ->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Dependency $dependency)
    {
        return view('dependency.edit', compact('dependency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dependency  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dependency $dependency)
    {
        return (int)$dependency->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dependency  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dependency $dependency)
    {
        return (int)$dependency->delete();
    }
}
