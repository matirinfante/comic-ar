<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Volume;
use App\Models\Edition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class VolumeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if ($request->coverFile==null){
            $urlImg=$request->coverImage;
        }else{
            $urlImg = $request->file('coverFile')->store('/comicar-cover');
        }
        $volume = Volume::create([
            'title' => $request->title,
            'ISBN' => $request->ISBN,
            'argument' => $request->argument,
            'coverImage' => $urlImg,
            'edition_id' => $request->edition_id
        ]);

        $volume->save();

        //return Redirect::route('editions.index');
        return ['redirect' => route('editions.index')];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Volume  $volume
     * @return \Illuminate\Http\Response
     */
    public function show(Volume $volume)
    {
        $edition = Edition::where('id', $volume->edition_id)->get();
        $volume = Volume::where('id', $volume->id)->get();

        // detectar si posee imagen en storage o usa la predeterminada de public
        $image = $volume[0]['coverImage'];
        if ($image != "/assets/cover/default.png") {
            if (str_contains($image, 'comicar-cover')) {
                $volume[0]['coverImage'] = asset('/storage/' . $image);
            } else {
                $volume[0]['coverImage'] = $image;
            }
        } else {
            $volume[0]['coverImage'] = "/assets/cover/default.png";
        }

        return Inertia::render('Volumes/Show', compact('volume', 'edition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Volume  $volume
     * @return \Illuminate\Http\Response
     */
    public function edit(Volume $volume)
    {
        return Inertia::render('Volumes/Edit', compact('volume'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Volume  $volume
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Volume $volume)
    {
        $image = $volume->coverImage;
        if ($request->hasFile('coverImage')) {
            Storage::delete($volume->coverImage);
            $image = $request->file('coverImage')->store('/comicar-cover');
            $volume->update([
                'title' => $request->title,
                'ISBN' => $request->ISBN,
                'argument' => $request->argument,
                'coverImage' => $image,
            ]);
        } else {
            // si el volumen tenía ya una imagen, no se actualiza
            if ($volume->coverImage != null) {
                $volume->update([
                    'title' => $request->title,
                    'ISBN' => $request->ISBN,
                    'argument' => $request->argument,
                ]);
            } else {
                $volume->update([
                    'title' => $request->title,
                    'ISBN' => $request->ISBN,
                    'argument' => $request->argument,
                    'coverImage' => "/assets/cover/default.png",
                ]);
            }
        }

        return Redirect::route('volumes.show', $volume->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Volume  $volume
     * @return \Illuminate\Http\Response
     */
    public function destroy(Volume $volume)
    {
        //
    }
}
