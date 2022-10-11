<?php

namespace App\Http\Controllers;

use App\Models\Comicteca;
use App\Models\Objective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId=Auth::id();
        $objectives=Objective::where('user_id',$userId)->get();
        return Inertia::render('Objectives/Index',compact('objectives'));
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
        $userId=Auth::id();
        $objective= Objective::create([
            'name'=>$request->name,
            'steps'=>$request->steps,
            'progress'=>0,
            'user_id'=>$userId
        ]);
        $objective->save();
        foreach($request->volumes as $volume){
            $objective->volumes()->attach($volume['id']); //por defecto pone "por leer". Chequear en caso de problemas
        }
        $objectives=Objective::where('user_id',$userId)->get();
        return $objectives;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Objective  $objective
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $objective=Objective::where('id',$request->id)->get();
        if (count($objective)==1){
            $objective[0]['porleer']=$objective[0]->volumes()->wherePivot('status','Por leer')->get(['id','title','coverImage']);
            $objective[0]['leyendo']=$objective[0]->volumes()->wherePivot('status','Leyendo')->get(['id','title','coverImage']);
            $objective[0]['leido']=$objective[0]->volumes()->wherePivot('status','Leido')->get(['id','title','coverImage']);
        }
        return $objective[0];
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Objective  $objective
     * @return \Illuminate\Http\Response
     */
    public function edit(Objective $objective)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Objective  $objective
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Objective $objective)
    {
        $objective=Objective::where('id',$request->id)->get();
        if (count($objective)==1){
            //$objective->volumes()->updateExistingPivot(19,['status'=>'Leido']);
            foreach($request->leer as $xleer){
                $objective[0]->volumes()->updateExistingPivot($xleer['id'],['status'=>'Por leer']);
            }
            foreach($request->leyendo as $leyendo){
                $objective[0]->volumes()->updateExistingPivot($leyendo['id'],['status'=>'Leyendo']);
            }
            foreach($request->leido as $leido){
                $objective[0]->volumes()->updateExistingPivot($leido['id'],['status'=>'Leido']);
            }
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Objective  $objective
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $objective=Objective::find($id);
        $volumes=$objective->volumes()->get();
        foreach($volumes as $volume){
            $objective->volumes()->detach($volume->id);
        }
        $objective->delete();
        $userId=Auth::id();
        $objectives=Objective::where('user_id',$userId)->get();
        return ($objectives);
    }

    public function searchBy(Request $request)
    {
        $userId=Auth::id();
        $comicteca=Comicteca::where('user_id',$userId)->get();
        $results=[];
        if (count($comicteca)==1){
            //Genero un array con todos los volumenes que ya se encuentran en algun objetivo
            $objectives=Objective::where('user_id',$userId)->get();
            $readed=[];
            foreach($objectives as $objective){
                $volumes=$objective->volumes()->get();
                foreach($volumes as $volume){
                    array_push($readed,$volume);
                }
            }

            $search=$comicteca[0]->volumes()->where('title', 'like', "%{$request->input('query')}%")->get(['id', 'title','number']);
            // Comparo los volumenes de la busqueda con los que estan en los objetivos
            // No quiero volumenes que ya se encuentran en algun objetivo
            foreach($search as $element){
                $found=false;
                foreach($readed as $vol){
                    if ($element['id']==$vol['id']){
                        $found=true;
                    }
                }
                if (!$found){
                    $element['title']=$element['title']." ".$element['number'];
                    array_push($results,$element);
                }
            }
        }
        return $results;
    }

    public function calculateProgress(Request $request){
        $objective=Objective::where('id',$request->id)->get();
        if (count($objective)==1){
            $cantComics=$request->leer+$request->leyendo+$request->leido;
            $partialProg=100/($cantComics*2);   //2 es leyendo y leido, Por Leer no suma progreso.
            $totalProg=($partialProg*$request->leyendo)+($partialProg*$request->leido*2);
            $objective[0]->progress=$totalProg;
            $objective[0]->save();
        }
        return $totalProg;
    }
}
