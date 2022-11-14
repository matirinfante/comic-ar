<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    //  Busca la insignia (badge) 'register' y consulta si el usuario actual está relacionado.
    //  Si esta relacionado retorna true.
    //  Si no esta relacionado, lo relaciona y luego retorna false.
    public function registerCheck(){
        $id=Auth::id();
        $regBadge=Badge::where('name','register')->first();
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


    // public function create()
    // {
    // }
    // public function store(Request $request)
    // {
    // }
    // public function show(Badge $badge)
    // {
    // }
    // public function edit(Badge $badge)
    // {
    // }
    // public function update(Request $request, Badge $badge)
    // {
    // }
    // public function destroy(Badge $badge)
    // {
    // }
}
