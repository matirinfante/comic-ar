<?php

namespace App\Http\Controllers;

use App\Models\Booklist;
use App\Models\Comicteca;
use App\Models\Objective;
use App\Models\User;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id=Auth::id();
        $user=User::find($id);
        $comicteca=Comicteca::where('user_id',$id)->first();
        $allVol=$comicteca->volumes()->get();
        $amount=count($allVol);
        $volumes=$comicteca->volumes()->orderByPivot('created_at','desc')->take(5)->get();
        foreach($volumes as $volume){
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
        }

        return Inertia::render('Users/Profile',compact('user','volumes','amount'));
    }

    public function getStats(){
        $id=Auth::id();
        $lists=Booklist::where('user_id',$id)->get();
        $booklists=count($lists);   //Cant de listas que creo el usuario
        $wishlist=Wishlist::where('user_id',$id)->first();
        $vol=$wishlist->volumes()->get();
        $volInWish=count($vol);    //Cantidad de volumenes en la wishlist
        $objectives=Objective::where('user_id',$id)->get();
        $completedObj=0;  //Objetivos completados
        $uncompletedObj=0;  //Objetivos no completados
        foreach ($objectives as $obj){
            if ($obj['progress']==100){
                $completedObj++;
            }else{
                $uncompletedObj++;
            }
        }
        

        $today=Carbon::now();
        $month=intval($today->isoFormat('OM'));
        $year=intval($today->isoFormat('OY'));
        //initMonth es donde comienzan a tomarse en cuenta los datos, de ahí 6 meses hasta el actual
        if ($month<=6){
            $initMonth=$month+12-5;
            $year--;
        }else{
            $initMonth=$month-5;
        }
        $allData=[];
        $values=['Mes','Listas','Objetivos','Deseados'];
        array_push($allData,$values);
        
        for($i=0; $i<6; $i++){
            $thisMonth=$initMonth+$i;
            if ($thisMonth>12){
                $thisMonth-=12;
            }
            $fakeDate=Carbon::create(0,$thisMonth,1,0,0,0);
            $name=$fakeDate->isoFormat('MMM');
            $lists=Booklist::where('user_id',$id)->where('created_at','like',$year."%".$thisMonth."-%")->get();
            $vol=$wishlist->volumes()->wherePivot('created_at','like',$year."%".$thisMonth."-%")->get();
            $obj=Objective::where('user_id',$id)->where('progress',100)->where('created_at','like',$year."%".$thisMonth."-%")->get();
            $values=[$name,count($lists),count($vol),count($obj)];
            array_push($allData,$values);
        }

        return (compact('booklists','volInWish','completedObj','uncompletedObj','allData'));
    }

    public function objMessage(){
        $user_id=Auth::id();
        $objectives=Objective::where('user_id',$user_id)->where('progress','<',100)->get();
        $message=null;
        if (count($objectives)>0){      
            foreach ($objectives as $objective){
                $days=$objective['days'];
                if ($days!=null){
                    $actualLocalDate=Carbon::parse(now())->timezone('America/Argentina/Buenos_Aires')->format('d-m-Y');
                    $objDate=Carbon::parse($objective['created_at'])->timezone('America/Argentina/Buenos_Aires')->format('d-m-Y');
                    $endDate=Carbon::parse($objDate)->addDays($days-1)->format('d-m-Y');
                    $diffDate=Carbon::parse($actualLocalDate)->diffInDays($endDate); 
                    $message.="Tu objetivo '".$objective['name']."' tiene un progreso de ".$objective['progress']."% ";
                    if($actualLocalDate==$endDate){
                        $message.="y es tu ultimo dia para completarlo.</br>";
                    }
                    if($actualLocalDate<$endDate){
                        $message.="y te quedan ".$diffDate." dia/s mas para completarlo.</br>";
                    }
                    if($actualLocalDate>$endDate){
                        $message.="y se encuentra retrasado por ".$diffDate." dia/s.</br>";
                    }
                }else{
                    $message.="Tu objetivo '".$objective['name']."' tiene un progreso de ".$objective['progress']."%.</br>";
                }
            }
        }
        return $message;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
