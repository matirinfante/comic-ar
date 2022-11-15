<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BadgeController extends Controller
{
    // public function registerCheck(){
    //     $badge='register';
    //     $found=BadgeController::checking($badge);
    //     return $found;
    // }
    // public function booklistCheck(){
    //     $badge='firstBooklist';
    //     $found=BadgeController::checking($badge);
    //     return $found;
    // }

    //  Busca la insignia (badge) y consulta si el usuario actual está relacionado.
    //  Si esta relacionado retorna true.
    //  Si no esta relacionado, lo relaciona y luego retorna false.
    public function badgeCheck(Request $request){
        $id=Auth::id();
        $regBadge=Badge::where('name',$request->badge)->first();
        $found=false;
        if($regBadge!=null){
            $user=$regBadge->users()->wherePivot('user_id',$id)->first();
            if ($user!=null){
                $found=true;
            }
        }
        if (!$found){
            $regBadge->users()->attach($id,['percentage'=>100]);
        }
        return $found;
    }
}
