<?php

namespace App\Http\Controllers;

use App\Pipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pipe.index', ['pipe'=>new Pipe()]);
    }

    public function datatable()
    {
        $p = $this->getPermission('pipe');
        $data = Pipe::all();
        if(isset($p))
            foreach($data as $d)
                $d['p'] = array('a'=>true,'e'=>$p->u,'d'=>$p->d);
        return datatables()->of($data)->toJson();
    }

    public function toggleActive(Pipe $pipe)
    {
        $active = $pipe->active > 0 ? 0 : 1;
        return (int) $pipe->update(["active"=>$active]);
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
            $data['photo'] = str_replace('public', 'storage', Storage::putFile('public/pipe/photo', $data['photo']));
        }
        return Pipe::create($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pipe  $pipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Pipe $pipe)
    {
        return view('pipe.edit', ["pipe"=>$pipe]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pipe  $pipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pipe $pipe)
    {
        $data = $request->all();
                
        if(isset($data['photo']))
        {
            Storage::delete(str_replace('storage', 'public', $pipe->photo));
            $data['photo'] = str_replace('public', 'storage', Storage::putFile('public/pipe/photo', $data['photo']));
            
        }

        return (int )$pipe->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pipe  $pipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pipe $pipe)
    {
        return (int) $pipe->delete();
    }
}
