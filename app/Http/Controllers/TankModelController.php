<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use App\Models\StorageTank;
use App\Models\TankModel;
//use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\Console\Input\Input;

class TankModelController extends Controller
{
    /**
     * manage tank
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all users
        $tankModel        = TankModel::all();
        $activeTanks      = StorageTank::all();
        $allSamplesinTank = Sample::all();

        // load the view and pass users, Frontend-team needs to give us the correct views
        return view('manageTanks')
            ->with('tankModel', $tankModel)
            ->with('activeTanks',$activeTanks)
            ->with('allSamplesinTank', $allSamplesinTank)
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // load the create form
        return View::make('tankModels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // store
        $tankModel = new tankModel;
        $tankModel->modelname       = $request->modelname;
        $tankModel->manufacturer    = $request->manufacturer;
        $tankModel->capacity        = $request->capacity;
        $tankModel->number_of_inserts = $request->number_of_inserts;
        $tankModel->number_of_tubes = $request->number_of_tubes;
        $tankModel->number_of_samples = $request->number_of_samples;
        $tankModel->save();

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        //this is pregenerated stub, can be used later if features are to be implemented
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        //this is pregenerated stub, can be used later if features are to be implemented
    }
}
