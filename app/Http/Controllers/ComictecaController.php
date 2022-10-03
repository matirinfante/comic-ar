<?php

namespace App\Http\Controllers;

use App\Models\Comicteca;
use App\Models\Edition;
use App\Models\Volume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ComictecaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();
        $comicteca=Comicteca::where('user_id',$userId)->get();
        $volumesCol=$comicteca[0]->volumes()->orderBy('edition_id')->orderBy('number')->get();
        //Divido por edicion
        $volumes=[];
        $edition=[];
        $editionNum=$volumesCol[0]['edition_id'];
        foreach($volumesCol as $volume){
            if($editionNum==$volume['edition_id']){
                $edTitle=Edition::where('id',$volume['edition_id'])->get('title');
                $volume['edition_title']=$edTitle[0];
                array_push($edition,$volume);
            }else{
                array_push($volumes,$edition);
                $edition=[];
                $editionNum=$volume['edition_id'];
                $edTitle=Edition::where('id',$volume['edition_id'])->get('title');
                $volume['edition_title']=$edTitle[0];
                array_push($edition,$volume);
            }
        }
        array_push($volumes,$edition);
        return Inertia::render('Comictecas/Index',compact('comicteca','volumes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        $comicteca=Comicteca::where('user_id',$userId)->get();
        if($request->input('status')){
            $comicteca[0]->volumes()->attach((array)$request->input('volume_id'));
        }else{
            $comicteca[0]->volumes()->detach((array)$request->input('volume_id'));
        }
        return ($comicteca[0]->volumes()->get());
    }

    public function completeEdition(Request $request){
        $userId = Auth::id();
        $comicteca=Comicteca::where('user_id',$userId)->get();
        $volumes=Volume::where('edition_id',$request->input('edition_id'))->get();
        foreach($volumes as $volume){
            $alreadyIn=false;   //Para que no hayan copias del volumen en la comicteca
            foreach ($comicteca[0]->volumes()->get() as $inComicteca){
                if ($volume->id == $inComicteca->id){
                    $alreadyIn=true;
                }
            }
            if(!$alreadyIn){
                $comicteca[0]->volumes()->attach((array)$volume->id);
            }
            $volume['inComicteca']=1;
        }
        return $volumes;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\comicteca  $comicteca
     * @return \Illuminate\Http\Response
     */
    public function show(comicteca $comicteca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\comicteca  $comicteca
     * @return \Illuminate\Http\Response
     */
    public function edit(comicteca $comicteca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\comicteca  $comicteca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, comicteca $comicteca)
    {
        $userId = Auth::id();
        $comicteca=Comicteca::where('user_id',$userId)->get();
        if($request->input('status')){
            $comicteca[0]->volumes()->attach((array)$request->input('volume_id'));
        }else{
            $comicteca[0]->volumes()->detach((array)$request->input('volume_id'));
        }

        $volumesCol=$comicteca[0]->volumes()->orderBy('edition_id')->orderBy('number')->get();
        //Divido por edicion
        $volumes=[];
        $edition=[];
        $editionNum=$volumesCol[0]['edition_id'];
        foreach($volumesCol as $volume){
            if($editionNum==$volume['edition_id']){
                $edTitle=Edition::where('id',$volume['edition_id'])->get('title');
                $volume['edition_title']=$edTitle[0];
                array_push($edition,$volume);
            }else{
                array_push($volumes,$edition);
                $edition=[];
                $editionNum=$volume['edition_id'];
                $edTitle=Edition::where('id',$volume['edition_id'])->get('title');
                $volume['edition_title']=$edTitle[0];
                array_push($edition,$volume);
            }
        }
        array_push($volumes,$edition);
        return ($volumes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\comicteca  $comicteca
     * @return \Illuminate\Http\Response
     */
    public function destroy(comicteca $comicteca)
    {
        //
    }
}
