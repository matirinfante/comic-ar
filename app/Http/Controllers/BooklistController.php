<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Booklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BooklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();
        $booklists = Booklist::all();
        foreach ($booklists as $book) {
            $book['usr'] = $book->user()->get()->first()->name;

            if ($book->user_id == $userId) {
                $book['actualUsr'] = 'y';
            } else {
                $book['actualUsr'] = 'n';
            }

            $volumes = $book->volumes()->get();
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
            }
            $book['vol'] = $volumes;
        }
        return Inertia::render('Booklists/Index', compact('booklists'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Booklist $booklist)
    {
        $booklist['usr'] = $booklist->user()->get()->first()->name;
        $volumes = $booklist->volumes()->get();

        $userId = Auth::id();
        if ($booklist['user_id'] == $userId) {
            $booklist['editPermission'] = 'y';
        } else {
            $booklist['editPermission'] = 'n';
        }

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
        }
        return Inertia::render('Booklists/Show', compact('booklist', 'volumes'));
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
        //
    }

    public function searchBy(Request $request)
    {
        $results = DB::table('booklists')->where('name', 'like', "%{$request->input('query')}%")->get(['id', 'name']);
        return $results;
    }
}
