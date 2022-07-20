<?php

namespace App\Http\Controllers;

use App\Models\StorageTank;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StorageTankController extends Controller
{
    /**
     * manage storged tanks
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // get all the storage tanks
        $storageTanks = StorageTank::all();

        // load the view and pass the storage tanks
        return view('manageTanks')
            ->with('tank', $storageTanks)
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //this is pregenerated stub, can be used later if features are to be implemented
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // validations
        $request->validate([
            'tank_number' => 'unique:storage_tank',
        ]);

        // store
        $storageTank = new storageTank;
        $storageTank->tank_number = $request->tank_number;
        $storageTank->modelname = $request->modelname;
        $storageTank->save();

        // redirect
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //this is pregenerated stub, can be used later if features are to be implemented
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //this is pregenerated stub, can be used later if features are to be implemented
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
        //this is pregenerated stub, can be used later if features are to be implemented
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        $storageTank = StorageTank::find($request->tank_id);
        $storageTank->delete();

        // redirect
        return redirect('/');
    }
}
