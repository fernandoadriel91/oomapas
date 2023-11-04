<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
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
        return view('department.index', ["department" => new Department()]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Department::create($request->all());
    }

    public function datatable()
    {
        $p = $this->getPermission('department');
        $data = Department::with('dependency');
        return datatables()->of($data)
            ->addColumn('p', function() use($p) {
                return [ 'a'=>false,'e'=>$p->u ?? false,'d'=>$p->d ?? false ];
            })
            ->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        return view('department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        return (int)$department->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        return (int)$department->delete();
    }
}
