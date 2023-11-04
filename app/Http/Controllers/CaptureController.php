<?php

namespace App\Http\Controllers;

use App\Capture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CaptureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('capture.index', ['capture'=>new Capture()]);
    }

    public function datatable()
    {
        $p = $this->getPermission('capture');
        $data = Capture::with('valve')->get();
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
        $data = $request->all();
        if(isset($data['photo']))
        {
            $data['photo'] = str_replace('public', 'storage', Storage::putFile('public/capture/photo', $data['photo']));
        }
        return Capture::create($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Capture  $capture
     * @return \Illuminate\Http\Response
     */
    public function edit(Capture $capture)
    {
        return view('capture.edit', ["capture"=>$capture]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Capture  $capture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Capture $capture)
    {
        $data = $request->all();
                
        if(isset($data['photo']))
        {
            Storage::delete(str_replace('storage', 'public', $capture->photo));
            $data['photo'] = str_replace('public', 'storage', Storage::putFile('public/capture/photo', $data['photo']));
            
        }

        return (int )$capture->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Capture  $capture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Capture $capture)
    {
        return (int) $capture->delete();
    }
}
