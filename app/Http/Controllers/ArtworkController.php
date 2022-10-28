<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Volume;
use App\Models\Artwork;
use App\Models\Edition;
use App\Models\Comicteca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ArtworkRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Redirect;

class ArtworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Artworks/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArtworkRequest $request)
    {
        $userId = Auth::id();
        $editionId = $request->editionId;
        $request->validated();

        if ($request->hasFile('imgUrl')) {

            // get filename with extension
            $filenamewithextension = $request->file('imgUrl')->getClientOriginalName();

            // get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            // get file extension
            $extension = $request->file('imgUrl')->getClientOriginalExtension();

            // filename to store
            $filenametostore = $filename . '_' . time() . '.' . $extension;

            // upload file
            $request->file('imgUrl')->storeAs('comicar-artwork', $filenametostore);

            // Resize img
            $path = public_path('storage/comicar-artwork/' . $filenametostore);
            $img = Image::make($request->file('imgUrl')->getRealPath());
            $img->save($path);

            $imgpath = 'comicar-artwork/' . $filenametostore;

            $artwork = Artwork::create([
                'title' => $request->title,
                'description' => $request->description,
                'imgUrl' => $imgpath,
                'user_id' => $userId,
                'edition_id' => $editionId,
            ]);

            $artwork->save();
        }
        $edition = Edition::where('id', $editionId)->get()->first();
        $volumes = Volume::where('edition_id', $editionId)->get();
        $artworks = Artwork::where('edition_id', $editionId)->orderBy('id', 'desc')->get();
        foreach ($artworks as $art) {
            $art['usr'] = $art->user()->get()->first()->name;
            if ($art['imgUrl'] != "/assets/cover/default.png") {
                if (str_contains($art['imgUrl'], 'comicar-artwork')) {
                    $art['imgUrl'] = asset('/storage/' . $art['imgUrl']);
                } else {
                    $art['imgUrl'] = $art['imgUrl'];
                }
            } else {
                $art['imgUrl'] = "/assets/cover/default.png";
            }
        }
        return Inertia::render('Artworks/Show', compact('edition', 'volumes','artworks'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $edition = Edition::where('id', $id)->get()->first();
        $volumes = Volume::where('edition_id', $id)->get();
        $artworks = Artwork::where('edition_id', $id)->orderBy('id', 'desc')->get();
        foreach ($artworks as $art) {
            $art['usr'] = $art->user()->get()->first()->name;
            if ($art['imgUrl'] != "/assets/cover/default.png") {
                if (str_contains($art['imgUrl'], 'comicar-artwork')) {
                    $art['imgUrl'] = asset('/storage/' . $art['imgUrl']);
                } else {

                    $art['imgUrl'] = $art['imgUrl'];
                }
            } else {
                $art['imgUrl'] = "/assets/cover/default.png";
            }
        }
        // return $edition;
        return Inertia::render('Artworks/Show', compact('edition', 'volumes','artworks'));
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
        return "update";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
