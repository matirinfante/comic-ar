<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Volume;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $volumes = null;
        $id = $request->user()->id;
        // busco usuario logueado
        $user = User::find($id);
        if ($user != null) {
            // obtengo la wishlist del usuario
            $userWishlist = $user->wishlists()->get();
            if (count($userWishlist) > 0) {
                // si existe la wishlist, obtengo los volúmenes
                $volumes = $userWishlist[0]->volumes()->get();
            }
        }
        return Inertia::render('Wishlists/Index', compact('volumes'));
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
        // Busco el usuario logueado actualmente
        $user = User::find($request->usr);
        $userWishlist = null;
        if ($user != null) {
            // si existe el usuario, busco la primer wishlist (única) de ese usuario
            $userWishlist = $user->wishlists()->get()->first();
            if ($userWishlist != null) {
                // si existe la wishlist, agrego el volúmen a tabla pivot
                // Agregar a volumen a deseados
                $userWishlist->volumes()->attach($request->volume_id);
            } else {
                // si el usuario no tiene ninguna wishlist, se crea
                $newWishlist = Wishlist::create([
                    'user_id' => $request->usr,
                ]);
                $newWishlist->save();
                // agrego el volúmen a tabla pivot
                $newWishlist->volumes()->attach($request->volume_id);
            }
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // descompongo el la variable id en 2 (wishlist_id & volume_id)
        $ids = explode('*', $id);
        $wishlist_id = $ids[0];
        $volume_id = $ids[1];
        // busco la wishlist con id = $wishlist_id
        $wishlist = Wishlist::find($wishlist_id);
        // if($wishlist != null){
            // saco el registro de la tabla pivot, con volume_id
        $wishlist->volumes()->detach($volume_id);
        // }

        // Retornos de prueba para ver que devuelven por consola (data)

        // return response()->json($wishlist->volumes()->get());
        return $wishlist->volumes()->get();
    }
}
