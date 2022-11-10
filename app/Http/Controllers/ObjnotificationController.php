<?php

namespace App\Http\Controllers;

use App\Mail\DailyNotification;
use App\Models\Objective;
use App\Models\Objnotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ObjnotificationController extends Controller
{
    
    public function index(){
        //$actualDate = date('d-m-Y H:i:s');
        $utcDate=now()->format('Y-m-d');
        $user_id=Auth::id();
        $todayNotif=Objnotification::where('user_id',$user_id)->where('created_at','like',$utcDate."%")->get();
        $objectives=Objective::where('user_id',$user_id)->where('progress','<',100)->get();
        if (count($todayNotif)==0 && count($objectives)>0){        
            $message="";
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
            $notification=Objnotification::create([
                'message' => $message,
                'readed' => false,
                'user_id' => $user_id
            ]);
            $notification->save();
            Mail::to('fake@mail.com')->send(new DailyNotification($message));
            //return $objectives;
        }
    }
    // public function create(){}
    // public function store(Request $request){}
    // public function show(Objnotification $objnotification){}
    // public function edit(Objnotification $objnotification){}
    public function update(Request $request, Objnotification $objnotification){
        $user_id=Auth::id();
        $utcDate=now()->format('Y-m-d');
        $objnotification=Objnotification::where('readed',false)->where('user_id',$user_id)->where('created_at','like',$utcDate."%")->get();
        $retorno='fallido';
        if(count($objnotification)==1){
            $objnotification[0]->readed=true;
            $objnotification[0]->save();
            $retorno='exito';
        }
        return $retorno;
    }
    // public function destroy(Objnotification $objnotification){}
    public function ask(Request $request){
        $resp=false;
        $user_id=Auth::id();
        $utcDate=now()->format('Y-m-d');
        $objnotification=Objnotification::where('readed',false)->where('user_id',$user_id)->where('created_at','like',$utcDate."%")->get();
        if($request->option==1){
            if(count($objnotification)==1){
                $resp=true;
            }
        }elseif($request->option==2){
            if(count($objnotification)==1){
                $resp=$objnotification[0]['message'];
            }
        }
        //elseif($request->option==3){
            // $objnotification=Objnotification::where('user_id',$user_id)->where('created_at','like',$utcDate."%")->get();
            // if(count($objnotification)==1){
            //     $resp=$objnotification[0]['message'];
            // }
        //}
        
        return $resp;
    }
}
