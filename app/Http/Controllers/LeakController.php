<?php

namespace App\Http\Controllers;

use App\Leak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('leak.index', ['leak'=>new Leak()]);
    }

    public function datatable()
    {
        $p = $this->getPermission('leak');
        $data = Leak::all();
        if(isset($p))
            foreach($data as $d)
                $d['p'] = array('a'=>true,'e'=>$p->u,'d'=>$p->d);
        return datatables()->of($data)->toJson();
    }

    public function toggleActive(Leak $leak)
    {
        $active = $leak->active > 0 ? 0 : 1;
        return (int) $leak->update(["active"=>$active]);
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
        if(isset($data['photo']))
        {
            $data['photo'] = str_replace('public', 'storage', Storage::putFile('public/leak/photo', $data['photo']));
        }
        return Leak::create($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Leak  $leak
     * @return \Illuminate\Http\Response
     */
    public function edit(Leak $leak)
    {
        return view('leak.edit', ["leak"=>$leak]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Leak  $leak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Leak $leak)
    {
        $data = $request->all();
                
        if(isset($data['photo']))
        {
            Storage::delete(str_replace('storage', 'public', $leak->photo));
            $data['photo'] = str_replace('public', 'storage', Storage::putFile('public/leak/photo', $data['photo']));
            
        }

        return (int )$leak->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leak  $leak
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leak $leak)
    {
        return (int) $leak->delete();
    }
}
