<?php

namespace App\Http\Controllers;

use App\Models\Volume;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $latest = Volume::orderBy('created_at', 'desc')->take(10)->get();
        $popular = Volume::all()->take(10);

        // detectar si posee imagen en storage o usa la predeterminada de public
        // LATEST
        foreach ($latest as $late) {
            $image = $late['coverImage'];
            if ($image != "/assets/cover/default.png") {
                if (str_contains($image, 'comicar-cover')) {
                    $late['coverImage'] = asset('/storage/' . $image);
                } else {
                    $late['coverImage'] = $image;
                }
            } else {
                $late['coverImage'] = "/assets/cover/default.png";
            }
        }

        // detectar si posee imagen en storage o usa la predeterminada de public
        // POPULAR
        foreach ($popular as $popu) {
            $image = $popu['coverImage'];
            if ($image != "/assets/cover/default.png") {
                if (str_contains($image, 'comicar-cover')) {
                    $popu['coverImage'] = asset('/storage/' . $image);
                } else {
                    $popu['coverImage'] = $image;
                }
            } else {
                $popu['coverImage'] = "/assets/cover/default.png";
            }
        }

        return Inertia::render('Dashboard', compact('latest', 'popular'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
