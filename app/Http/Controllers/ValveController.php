<?php

namespace App\Http\Controllers;

use App\Valve;
use Illuminate\Http\Request;

class ValveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("valve.index", ["valve"=>new Valve()]);
    }

    public function datatable()
    {
        $p = $this->getPermission('valve');
        $data = Valve::all();
        if(isset($p))
            foreach($data as $d)
                $d['p'] = array('a'=>false,'e'=>$p->u,'d'=>$p->d);
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
        return Valve::create($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Valve  $valve
     * @return \Illuminate\Http\Response
     */
    public function edit(Valve $valve)
    {
        return view('valve.edit', ["valve"=>$valve]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Valve  $valve
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Valve $valve)
    {
        return (int )$valve->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Valve  $valve
     * @return \Illuminate\Http\Response
     */
    public function destroy(Valve $valve)
    {
        return (int) $valve->delete();
    }
}
