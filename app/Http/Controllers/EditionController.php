<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\Volume;
use App\Models\Edition;
use Illuminate\Http\Request;
use App\Http\Resources\EditionResource;
use Illuminate\Support\Facades\Redirect;

class EditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $editions = EditionResource::collection(Edition::all());
        $editions = Edition::all();
        $cont = 0;
        foreach ($editions as $edition) {
            $vol = Volume::select('coverImage')->where('edition_id', $edition->id)->first();
            if ($vol != null) {
                $editions[$cont]['cover'] = $vol->coverImage;
            } else {
                $editions[$cont]['cover'] = "/assets/cover/default.png";
            }
            $cont++;
        }
        return Inertia::render('Editions/Index', compact('editions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Editions/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Falta validar

        $edition = Edition::create([
            'title' => $request->title,
            'publisher' => $request->publisher,
            'language' => $request->language,
            'format' => $request->format,
            'isStandalone' => $request->isStandalone,
            'description' => $request->description
        ]);

        $edition->save();

        // si no es edición única, se crean los volúmenes asociados a la edición
        if ($request->isStandalone == false) {
            $cantVol = $request->cantVol;
            for ($i = 0; $i < $cantVol; $i++) {
                Volume::create([
                    'title' => $edition->title,
                    'edition_id' => $edition->id
                ])->save();
            }
        }

        return Redirect::route('editions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Edition $edition
     * @return \Illuminate\Http\Response
     */
    public function show(Edition $edition)
    {
        $volumes = Volume::where('edition_id', $edition->id)->get();
        return Inertia::render('Editions/Show', compact('edition', 'volumes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Edition $edition
     * @return \Illuminate\Http\Response
     */
    public function edit(Edition $edition)
    {
        return Inertia::render('Editions/Edit', compact('edition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Edition $edition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Edition $edition)
    {
        // validate


        $edition->update([
            'title' => $request->title,
            'publisher' => $request->publisher,
            'language' => $request->language,
            'format' => $request->format,
            'isClosed' => $request->isClosed,
            'description' => $request->description,
        ]);

        return Redirect::route('editions.show', $edition->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Edition $edition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Edition $edition)
    {
        //
    }

    public function searchBy(Request $request)
    {
        $results = DB::table('editions')->where('title', 'like', "%{$request->input('query')}%")->get(['id', 'title']);
        return $results;
    }
}
