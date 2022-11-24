<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Booklist;
use App\Models\Comicteca;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BadgeController extends Controller
{
    //  Busca la insignia (badge) y consulta si el usuario actual está relacionado.
    //  Si esta relacionado retorna false.
    //  Si no esta relacionado, lo relaciona y luego retorna true.
    // En caso de firstBooklist tiene que comprobar que el usuario haya creado una.
    public function badgeCheck(Request $request){
        $id=Auth::id();
        $regBadge=Badge::where('name',$request->badge)->first();
        $notificate=false;
        $userFound=false;
        if($regBadge!=null){
            $user=$regBadge->users()->wherePivot('user_id',$id)->first();
            if ($user!=null){
                $userFound=true;
            }
            if($regBadge->name=='firstBooklist'){
                $booklist=Booklist::where('user_id',$id)->first();
                if($booklist!=null){
                    if (!$userFound){
                        $regBadge->users()->attach($id);
                        $notificate=true;
                    }
                }
            }else{
                if (!$userFound){
                    $regBadge->users()->attach($id);
                    $notificate=true;
                }
            }
        }
        return $notificate;
    }

    //  Busca la cantidad de volumenes en la comicteca.
    //  Dependiendo de la cantidad va a entrar en las condiciones (bronze,silver,gold) y chequear si el usuario ya dispone de las insignias (con la funcion addBadge).
    //  Si no tiene alguna de las insignias y cumple con las condiciones: genera la relación y retorna false.
    //  Si no cumple con las condiciones y/o ya dispone de las insignias: retorna true. 
    public function comictecaStatus(Request $request){
        $id=Auth::id();
        $comicteca=Comicteca::where('user_id',$id)->first();
        $volumes=count($comicteca->volumes()->get());
        $badge=null;
        $found=true;
        $isSet=true;
        if($volumes>=1){
            $badge=Badge::where('name','comictecaBronze')->first();
            $isSet=BadgeController::addBadge($badge,$id);
        }
        if(!$isSet){
            $found=false;
        }
        if($volumes>=10 && $volumes<50){
            $badge=Badge::where('name','comictecaSilver')->first();
            $isSet=BadgeController::addBadge($badge,$id);
        }
        if(!$isSet){
            $found=false;
        }
        if($volumes>=50){
            $badge=Badge::where('name','comictecaGold')->first();
            $isSet=BadgeController::addBadge($badge,$id);            
        }
        if(!$isSet){
            $found=false;
        }

        return $found;
    }

    //  Busca la cantidad de volumenes en la wishlist.
    //  Dependiendo de la cantidad va a entrar en las condiciones (bronze,silver,gold) y chequear si el usuario ya dispone de las insignias (con la funcion addBadge).
    //  Si no tiene alguna de las insignias y cumple con las condiciones: genera la relación y retorna false.
    //  Si no cumple con las condiciones y/o ya dispone de las insignias: retorna true. 
    public function wishStatus(Request $request){
        $id=Auth::id();
        $wishlist=Wishlist::where('user_id',$id)->first();
        $found=true;
        if($wishlist!=null){
            $volumes=count($wishlist->volumes()->get());
            $badge=null;
            $isSet=true;
            if($volumes>=1 && $volumes<10){
                $badge=Badge::where('name','wishlistBronze')->first();
                $isSet=BadgeController::addBadge($badge,$id);
            }elseif($volumes>=10 && $volumes<50){
                $badge=Badge::where('name','wishlistSilver')->first();
                $isSet=BadgeController::addBadge($badge,$id);
            }elseif($volumes>=50){
                $badge=Badge::where('name','wishlistGold')->first();
                $isSet=BadgeController::addBadge($badge,$id);            
            }
            if(!$isSet){
                $found=false;
            }
        }
        return $found;
    }

    //  Si el usuario no tiene la insignia: genera la relacion y retorna false.
    //  Si ya tiene la insignia retorna true.
    public function addBadge($badge,$userId){
        $isSet=false;
        if($badge!=null){
            $user=$badge->users()->wherePivot('user_id',$userId)->first();
            if ($user!=null){
                $isSet=true;
            }
            if (!$isSet){
                $badge->users()->attach($userId);
            }
        }
        return $isSet;
    }

    public function showBadges(){
        $id=Auth::id();
        $user=User::find($id);
        $badges=$user->badges()->orderBy('id')->get();
        return $badges;
    }

}
