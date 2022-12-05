<?php

namespace App\Http\Controllers;

use App\Models\Comicteca;
use App\Models\Edition;
use App\Models\Volume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Psy\Util\Json;

class ComictecaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();
        $comicteca = Comicteca::where('user_id', $userId)->get();
        $volumesCol = $comicteca[0]->volumes()->orderBy('edition_id')->orderBy('number')->get();
        $edCol = [];
        if (count($volumesCol) > 0) {
            $edition = [];
            $edition['volumes'] = [];
            $editionNum = $volumesCol[0]['edition_id'];
            $editionDB = Edition::find($editionNum);
            $volTotal = count($editionDB->volumes);
            $volProgress = 0;
            foreach ($volumesCol as $volume) {
                //Renombrando ruta de la imagen
                if ($volume['coverImage'] != "/assets/cover/default.png") {
                    if (str_contains($volume['coverImage'], 'comicar-cover')) {
                        $volume['coverImage'] = asset('/storage/' . $volume['coverImage']);
                    } else {

                        $volume['coverImage'] = $volume['coverImage'];
                    }
                } else {
                    $volume['coverImage'] = "/assets/cover/default.png";
                }
                //Divido por edicion

                $editionDB = Edition::find($volume['edition_id']);
                if ($editionNum == $volume['edition_id']) {
                    $edition['title'] = $editionDB['title'];
                    $volProgress++;
                    array_push($edition['volumes'], $volume);
                } else {
                    $edition['progress'] = round((100 / $volTotal) * $volProgress);
                    array_push($edCol, $edition);
                    $edition = [];
                    $edition['volumes'] = [];
                    $volTotal = count($editionDB->volumes);
                    $volProgress = 1;
                    $editionNum = $volume['edition_id'];
                    $edition['title'] = $editionDB['title'];
                    array_push($edition['volumes'], $volume);
                }
            }
            //La ultima edicion se guarda luego del foreach.
            $edition['progress'] = round((100 / $volTotal) * $volProgress);
            array_push($edCol, $edition);
        }
        return Inertia::render('Comictecas/Index', compact('comicteca', 'edCol'));
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
        $userId = Auth::id();
        $comicteca = Comicteca::where('user_id', $userId)->get();
        if ($request->input('status')) {
            $comicteca[0]->volumes()->attach((array)$request->input('volume_id'));
        } else {
            $comicteca[0]->volumes()->detach((array)$request->input('volume_id'));
        }
        return ($comicteca[0]->volumes()->get());
    }

    public function completeEdition(Request $request)
    {
        $userId = Auth::id();
        $comicteca=Comicteca::where('user_id',$userId)->get();
        $volumes=Volume::where('edition_id',$request->input('edition_id'))->get();
        foreach($volumes as $volume){
            if ($volume['coverImage'] != "/assets/cover/default.png") {
                if (str_contains($volume['coverImage'], 'comicar-cover')) {
                    $volume['coverImage'] = asset('/storage/' . $volume['coverImage']);
                } else {

                    $volume['coverImage'] = $volume['coverImage'];
                }
            } else {
                $volume['coverImage'] = "/assets/cover/default.png";
            }
            $alreadyIn=false;   //Para que no hayan copias del volumen en la comicteca
            foreach ($comicteca[0]->volumes()->get() as $inComicteca){
                if ($volume->id == $inComicteca->id){
                    $alreadyIn=true;
                }
            }
            if (!$alreadyIn) {
                $comicteca[0]->volumes()->attach((array)$volume->id);
            }
            $volume['inComicteca'] = 1;
        }
        return $volumes;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\comicteca $comicteca
     * @return \Illuminate\Http\Response
     */
    public function show(comicteca $comicteca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\comicteca $comicteca
     * @return \Illuminate\Http\Response
     */
    public function edit(comicteca $comicteca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\comicteca $comicteca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, comicteca $comicteca)
    {
        $userId = Auth::id();
        $comicteca = Comicteca::where('user_id', $userId)->get();
        if ($request->input('status')) {
            $comicteca[0]->volumes()->attach((array)$request->input('volume_id'));
        } else {
            $comicteca[0]->volumes()->detach((array)$request->input('volume_id'));
        }

        $volumesCol = $comicteca[0]->volumes()->orderBy('edition_id')->orderBy('number')->get();
        $edCol = [];
        if (count($volumesCol) > 0) {
            $edition = [];
            $edition['volumes'] = [];
            $editionNum = $volumesCol[0]['edition_id'];
            $editionDB = Edition::find($editionNum);
            $volTotal = count($editionDB->volumes);
            $volProgress = 0;
            foreach ($volumesCol as $volume) {
                //Renombrando ruta de la imagen
                if ($volume['coverImage'] != "/assets/cover/default.png") {
                    if (str_contains($volume['coverImage'], 'comicar-cover')) {
                        $volume['coverImage'] = asset('/storage/' . $volume['coverImage']);
                    } else {

                        $volume['coverImage'] = $volume['coverImage'];
                    }
                } else {
                    $volume['coverImage'] = "/assets/cover/default.png";
                }
                //Divido por edicion
                $editionDB = Edition::find($volume['edition_id']);
                if ($editionNum == $volume['edition_id']) {
                    $edition['title'] = $editionDB['title'];
                    $volProgress++;
                    array_push($edition['volumes'], $volume);
                } else {
                    $edition['progress'] = round((100 / $volTotal) * $volProgress);
                    array_push($edCol, $edition);
                    $edition = [];
                    $edition['volumes'] = [];
                    $volTotal = count($editionDB->volumes);
                    $volProgress = 1;
                    $editionNum = $volume['edition_id'];
                    $edition['title'] = $editionDB['title'];
                    array_push($edition['volumes'], $volume);
                }
            }
            $edition['progress'] = round((100 / $volTotal) * $volProgress);
            array_push($edCol, $edition);
        }
        return ($edCol);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\comicteca $comicteca
     * @return \Illuminate\Http\Response
     */
    public function destroy(comicteca $comicteca)
    {
        //
    }

    public function comictecaUser(Request $request)
    {
        $query = DB::table('comictecas')->where('user_id', $request->id)
            ->selectRaw('editions.id, COUNT(volumes.id) as volumesOwned')
            ->join('comicteca_volume', 'comicteca_volume.comicteca_id', "=", "comictecas.id")
            ->join('volumes', 'volumes.id', "=", "comicteca_volume.volume_id")
            ->join('editions', 'editions.id', "=", 'volumes.edition_id')
            ->groupBy('editions.id')
            ->distinct()
            ->get();
        $editions = 0;
        foreach ($query as $edition) {
            $temp = Edition::where('id', $edition->id)->first();
            $edition->title = $temp->title;
            $totalVolumes = Volume::where('edition_id', $edition->id)->count();
            $edition->totalVolumes = $totalVolumes;
            $inPosession = DB::table('comictecas')->where('user_id', $request->id)
                ->join('comicteca_volume', 'comicteca_volume.comicteca_id', "=", "comictecas.id")
                ->join('volumes', 'volumes.id', "=", "comicteca_volume.volume_id")
                ->join('editions', 'editions.id', "=", 'volumes.edition_id')
                ->where('volumes.edition_id', "=", $edition->id)
                ->get(['volumes.id']);
            $final = [];
            foreach ($inPosession as $id) {
                $final[] = $id->id;
            }

            $volumesLeft = DB::table('volumes')
                ->where('edition_id', $edition->id)
                ->whereNotIn('id', $final)
                ->get();

            $edition->volumesLeft = $volumesLeft;
            $edition->coverImage = $temp->volumes()->first()->coverImage;
            $editions++;
        }
//        $totalComics = Comicteca::where('user_id', $request->id)->first()->volumes()->get()->count();
//        $query->add(['totalComics' => $totalComics, 'editions' => $editions]);
        return Response()->json($query);
    }

    public function addToComicteca(Request $request)
    {
        $comictecaUser = Comicteca::where('user_id', $request->user_id)->first();
        $volume = Volume::where('id', $request->volume_id)->first();
        $checkPresence = $comictecaUser->volumes()->find($request->volume_id);
        $response = [];
        if (!$checkPresence) {
            $comictecaUser->volumes()->attach($volume->id);
            $response = ['status' => 'Added to comicteca. Volume ID: ' . $comictecaUser->volumes()->find($volume->id)->id];
            return Response()->json($response, 201);
        } else {
            $response = ['error' => "Volume already added in Comicteca!"];
            return Response()->json($response, 409);
        }
    }

    public function comictecaStats(Request $request)
    {
        $query = DB::table('comictecas')->where('user_id', $request->id)
            ->selectRaw('editions.id')
            ->join('comicteca_volume', 'comicteca_volume.comicteca_id', "=", "comictecas.id")
            ->join('volumes', 'volumes.id', "=", "comicteca_volume.volume_id")
            ->join('editions', 'editions.id', "=", 'volumes.edition_id')
            ->groupBy('editions.id')
            ->distinct()
            ->get();
        $editions = 0;
        foreach ($query as $edition) {
            $editions++;
        }
        $totalComics = Comicteca::where('user_id', $request->id)->first()->volumes()->get()->count();
        $response = ['totalComics' => $totalComics, 'editions' => $editions];
        return Response()->json($response);
    }

    public function checkAdded(Request $request){
        $comictecaUser = Comicteca::where('user_id', $request->id)->first();
        $checkPresence = $comictecaUser->volumes()->find($request->volume_id);

        if ($checkPresence){
            return Response()->json(true);
        } else {
            return Response()->json(false);
        }
    }
}
