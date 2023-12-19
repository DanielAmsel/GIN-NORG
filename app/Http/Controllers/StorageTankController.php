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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // validations
        $request->validate([
            'tank_name' => 'unique:storage_tank',
        ]);

        // store
        $storageTank = new storageTank;
        $storageTank->tank_name = $request->tank_name;
        $storageTank->modelname = $request->modelname;
        $storageTank->save();

        // redirect
        return redirect('/');
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
        return redirect('/manageTanks');
    }
}
