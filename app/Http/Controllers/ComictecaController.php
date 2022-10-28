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
        $edCol=[];
        if (count($volumesCol)>0){
            $edition=[];
            $edition['volumes']=[];
            $editionNum=$volumesCol[0]['edition_id'];
            $editionDB=Edition::find($editionNum);
            $volTotal=count($editionDB->volumes);
            $volProgress=0;
            foreach($volumesCol as $volume){
                //Renombrando ruta de la imagen
                if ($volume['coverImage'] != "/assets/cover/default.png") {
                    if (str_contains($volume['coverImage'], 'comicar-cover')) {
                        $volume['coverImage'] = asset('/storage/' . $volume['coverImage']);
                    } else {
    
                        $volume['coverImage'] = $volume['coverImage'];
                    }
                } else {
                    $volume['coverImage'] = "/assets/cover/default.png";
                }
                //Divido por edicion

                $editionDB=Edition::find($volume['edition_id']);
                if($editionNum==$volume['edition_id']){
                    $edition['title']=$editionDB['title'];
                    $volProgress++;
                    array_push($edition['volumes'],$volume);
                }else{
                    $edition['progress']=round((100/$volTotal)*$volProgress);
                    array_push($edCol,$edition);
                    $edition=[];
                    $edition['volumes']=[];
                    $volTotal=count($editionDB->volumes);
                    $volProgress=1;
                    $editionNum=$volume['edition_id'];
                    $edition['title']=$editionDB['title'];
                    array_push($edition['volumes'],$volume);
                }
            }
            //La ultima edicion se guarda luego del foreach.
            $edition['progress']=round((100/$volTotal)*$volProgress);
            array_push($edCol,$edition);
        }
        return Inertia::render('Comictecas/Index',compact('comicteca','edCol'));
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
        $edCol=[];
        if (count($volumesCol)>0){
            $edition=[];
            $edition['volumes']=[];
            $editionNum=$volumesCol[0]['edition_id'];
            $editionDB=Edition::find($editionNum);
            $volTotal=count($editionDB->volumes);
            $volProgress=0;
            foreach($volumesCol as $volume){
                //Renombrando ruta de la imagen
                if ($volume['coverImage'] != "/assets/cover/default.png") {
                    if (str_contains($volume['coverImage'], 'comicar-cover')) {
                        $volume['coverImage'] = asset('/storage/' . $volume['coverImage']);
                    } else {
    
                        $volume['coverImage'] = $volume['coverImage'];
                    }
                } else {
                    $volume['coverImage'] = "/assets/cover/default.png";
                }
                //Divido por edicion
                $editionDB=Edition::find($volume['edition_id']);
                if($editionNum==$volume['edition_id']){
                    $edition['title']=$editionDB['title'];
                    $volProgress++;
                    array_push($edition['volumes'],$volume);
                }else{
                    $edition['progress']=round((100/$volTotal)*$volProgress);
                    array_push($edCol,$edition);
                    $edition=[];
                    $edition['volumes']=[];
                    $volTotal=count($editionDB->volumes);
                    $volProgress=1;
                    $editionNum=$volume['edition_id'];
                    $edition['title']=$editionDB['title'];
                    array_push($edition['volumes'],$volume);
                }
            }
            $edition['progress']=round((100/$volTotal)*$volProgress);
            array_push($edCol,$edition);
        }
        return ($edCol);
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
