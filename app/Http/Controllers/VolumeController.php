<?php

namespace App\Http\Controllers;

use App\Jobs\EditionUpdateJob;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Volume;
use App\Models\Edition;
use App\Mail\EditionNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Stichoza\GoogleTranslate\GoogleTranslate;

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

        //coverFile has uploaded image
        //coverImage has image by url
        if (!($request->coverImage == null)) {
            $contents = file_get_contents($request->coverImage);
            $hasExt = substr($request->coverImage, -4, 4);
            if ($hasExt == '.jpg' || $hasExt == '.png') {
                $filenametostore = substr($request->coverImage, strrpos($request->coverImage, '/') + 1);
            } else {
                $filename = $request->ISBN;
                $extension = 'jpg';
                $filenametostore = $filename . '_' . time() . '.' . $extension;
            }


            // upload file
            $imgpath = 'comicar-cover/' . $filenametostore;
            Storage::put($imgpath, $contents);

            // Resize img
            $path = public_path('storage/comicar-cover/' . $filenametostore);
            $img = Image::make($path)->resize(263, 400);
            $img->save($path);
        } elseif (!($request->coverFile == null)) {
            // get filename with extension
            $filenamewithextension = $request->file('coverFile')->getClientOriginalName();

            // get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            // get file extension
            $extension = $request->file('coverFile')->getClientOriginalExtension();

            // filename to store
            $filenametostore = $filename . '_' . time() . '.' . $extension;

            // upload file
            $request->file('coverFile')->storeAs('comicar-cover', $filenametostore);

            // Resize img
            $path = public_path('storage/comicar-cover/' . $filenametostore);
            $img = Image::make($request->file('coverFile')->getRealPath())->resize(263, 400);
            $img->save($path);

            $imgpath = 'comicar-cover/' . $filenametostore;
        } else {
            //If no image was sent by form
            $imgpath = "/assets/cover/default.png";
        }


        $volume = Volume::create([
            'title' => $request->title,
            'number' => $request->number,
            'ISBN' => $request->ISBN,
            'argument' => $request->argument,
            'coverImage' => $imgpath,
            'edition_id' => $request->edition_id
        ]);

        $volume->save();

        // Busco la edición por su id
        $edition = Edition::find($request->edition_id);
        // obtengo los usuarios "suscriptos" a esa edición
        $usersSubs = $edition->users()->get();
        
        // envío de mails a usuarios que quieren recibir novedades de la edición
        $this->dispatch(new EditionUpdateJob($edition, $volume, $usersSubs));

        //return Redirect::route('editions.index');
        return ['redirect' => route('editions.index')];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Volume  $volume
     * @return \Illuminate\Http\Response
     */
    public function show(Volume $volume, Request $request)
    {
        $edition = Edition::where('id', $volume->edition_id)->get();
        $volume = Volume::where('id', $volume->id)->get();


        $id = $request->user()->id;
        $user = User::find($id);
        $volume[0]['inWishlist'] = 0;
        $volume[0]['usr'] = null;
        if ($user != null) {
            $userWishlist = $user->wishlists()->get();
            $volWish = null;
            if (count($userWishlist) > 0) {
                $volWish = $userWishlist[0]->volumes()->where('id', $volume[0]['id'])->get();
                if (count($volWish) > 0) {
                    $volume[0]['inWishlist'] = 1;
                }
            }
            $volume[0]['usr'] = $id;
        }

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

        if ($request->hasFile('coverImage')) {
            Storage::delete($volume->coverImage);

            // get filename with extension
            $filenamewithextension = $request->file('coverImage')->getClientOriginalName();

            // get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            // get file extension
            $extension = $request->file('coverImage')->getClientOriginalExtension();

            // filename to store
            $filenametostore = $filename . '_' . time() . '.' . $extension;

            // upload file
            $request->file('coverImage')->storeAs('comicar-cover', $filenametostore);

            // Resize img
            $path = public_path('storage/comicar-cover/' . $filenametostore);
            $img = Image::make($request->file('coverImage')->getRealPath())->resize(263, 400);
            $img->save($path);

            $volume->update([
                'title' => $request->title,
                'number' => $request->number,
                'ISBN' => $request->ISBN,
                'argument' => $request->argument,
                'coverImage' => 'comicar-cover/' . $filenametostore,
            ]);
        } else {
            // si el volumen tenía ya una imagen, no se actualiza
            if ($volume->coverImage != null) {
                $volume->update([
                    'title' => $request->title,
                    'number' => $request->number,
                    'ISBN' => $request->ISBN,
                    'argument' => $request->argument,
                ]);
            } else {
                $volume->update([
                    'title' => $request->title,
                    'number' => $request->number,
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

    public function searchBy(Request $request)
    {
        $results = DB::table('volumes')->selectRaw('CONCAT(title, "(#", number, ")") as title, id')->where('title', 'like', "%{$request->input('query')}%")->get();

        // títulos de volúmenes con su número de orden(por edición) y publisher correspondiente
        // *** ROMPE LA BÚSQUEDA DESPUES DEL PRIMER RESULTADO
        // $results = DB::table('volumes')->join('editions', 'volumes.edition_id', '=', 'editions.id')
        // ->selectRaw('CONCAT(volumes.title, "(#", volumes.number, ") ", editions.publisher) as title')
        // ->where('volumes.title', 'like', "%{$request->input('query')}%")
        // ->get();
        return $results;
    }
    public function translate(){
        $url="https://animechan.vercel.app/api/random";
        //Busqueda de una frase que no supere 200 caracteres
        do{
            $data=json_decode(file_get_contents($url),true);
            $length=strlen($data['quote']);
        }while($length>200);
        //Traduccion
        $tr = new GoogleTranslate(); 
        $tr->setSource('en'); 
        $tr->setTarget('es'); 
        $data['quote']=$tr->translate($data['quote']);
        return $data;
    }
}
