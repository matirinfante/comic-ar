<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditionRequest;
use App\Models\Comicteca;
use GuzzleHttp\Client;
use Inertia\Inertia;
use App\Models\Volume;
use App\Models\Edition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\Auth;
use Mtownsend\XmlToArray\XmlToArray;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;
use Spatie\ArrayToXml\ArrayToXml;


class EditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $editions = Edition::all();
        $editions = Edition::orderBy('created_at', 'desc')->paginate(6);
        $cont = 0;
        // Si la edición cuenta con al menos un volúmen, ésta tendrá la portada del primer volumen encontrado
        foreach ($editions as $edition) {
            $vol = Volume::select('coverImage')->where('edition_id', $edition->id)->first();
            if ($vol != null) {
                // detectar si posee imagen en storage o usa la predeterminada de public
                if ($vol->coverImage != "/assets/cover/default.png") {
                    if (str_contains($vol->coverImage, 'comicar-cover')) {
                        $edition['cover'] = asset('/storage/' . $vol->coverImage);
                    } else {

                        $edition['cover'] = $vol->coverImage;
                    }
                } else {
                    $edition['cover'] = "/assets/cover/default.png";
                }
            } else {
                $edition['cover'] = "/assets/cover/default.png";
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
    public function store(EditionRequest $request)
    {
        $edition = Edition::create($request->validated());

        $edition->save();

        $contNumber = 1;

        // si no es edición única, se crean los volúmenes asociados a la edición
        if ($request->isStandalone == false) {
            $cantVol = $request->cantVol;

            for ($i = 0; $i < $cantVol; $i++) {
                Volume::create([
                    'title' => $edition->title,
                    'number' => $contNumber,
                    'edition_id' => $edition->id
                ])->save();

                $contNumber++;
            }
        } else {  //si es edición única se crea un solo volumen
            Volume::create([
                'title' => $edition->title,
                'number' => $contNumber,
                'edition_id' => $edition->id
            ])->save();
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
        $userId = Auth::id();
        $comictecaId = Comicteca::where('user_id', $userId)->get('id');
        $totalVol = count(Volume::where('edition_id', $edition->id)->get());
        $edition['totalVol'] = $totalVol;
        $volumes = Volume::where('edition_id', $edition->id)->orderBy('number', 'asc')->paginate(6);
        foreach ($volumes as $volume) {
            if ($volume['coverImage'] != "/assets/cover/default.png") {
                if (str_contains($volume['coverImage'], 'comicar-cover')) {
                    $volume['coverImage'] = asset('/storage/' . $volume['coverImage']);
                } else {

                    $volume['coverImage'] = $volume['coverImage'];
                }
            } else {
                $volume['coverImage'] = "/assets/cover/default.png";
            }
            $volComic = $volume->comictecas()->where('id', $comictecaId[0]->id)->get();
            if (count($volComic) > 0) {
                $volume['inComicteca'] = 1;
            } else {
                $volume['inComicteca'] = 0;
            }
            $totalVol++;
            $volume['totalVol'] = $totalVol;
        }
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
            'characters' => $request->characters
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

    public function getCharactersFromAPI(Request $request)
    {
        $theUrl = config('app.API')
            . '&filter=name:' . $request->partialText . '&field_list=id,name,image&limit=5';
        $response = Http::get($theUrl);
        return $response->json();
    }

    public function checkISBN(Request $request)
    {
        $client = new Client();
        $headers = [
            'Content-Type' => 'text/xml; charset=utf-8'
        ];

        $xml = [
            'soap:Body' => [
                'IsValidISBN13' => [
                    '_attributes' => ['xmlns' => "http://webservices.daehosting.com/ISBN"],
                    'sISBN' => $request->isbn
                ]
            ]
        ];

        $requestBody = ArrayToXml::convert($xml, [
            'rootElementName' => 'soap:Envelope',
            '_attributes' => ['xmlns:soap' => "http://schemas.xmlsoap.org/soap/envelope/"]
        ], true, 'UTF-8');
        $payload = new \GuzzleHttp\Psr7\Request('POST', 'http://webservices.daehosting.com/services/isbnservice.wso', $headers, $requestBody);
        $res = $client->sendAsync($payload)->wait();
        $responseString = XmlToArray::convert($res->getBody()->getContents());
        return Response()->json($responseString['soap:Body']['m:IsValidISBN13Response']['m:IsValidISBN13Result']);
    }
}
