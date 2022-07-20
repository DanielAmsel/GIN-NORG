<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Http\Request;
use App\Models\StorageTank;
use App\Models\TankCapacity;

/**
 *
 */
class CombinedTankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application
     * @return \Illuminate\Contracts\View\Factory
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // get all the storage tanks
        $storageTanks = StorageTank::all();

        // get all the tank capacities
        $tankCapacities = TankCapacity::all();

        // get all the samples
        $samples = Sample::all();

        // load the view and pass the info
        return view('home',[
            'tanksValue'  => $storageTanks->count(),
            'insertValue' => $tankCapacities->value('number_of_inserts') ,
            'tubesValue'  => $tankCapacities->value('number_of_tubes'),
            'sampleValue' => $tankCapacities->value('number_of_samples'),
        ])
            ->with('tankcapacities', $tankCapacities)
            ->with('storageTanks', $storageTanks)
            ->with('samples', $samples )
        ;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application
     * @return \Illuminate\Contracts\View\Factory
     * @return \Illuminate\Contracts\View\View
     */
    public function indextest()
    {
        // get all the storage tanks
        $storageTanks = StorageTank::all();

        // get all the tank capacities
        $tankCapacities = TankCapacity::all();

        // get all the samples
        $samples = Sample::all();

        // load the view and pass the info
        return view('dataTest',[
            'tanksValue' => $storageTanks->count(),
            'insertValue' => $tankCapacities->value('number_of_inserts') ,
            'tubesValue' => $tankCapacities->value('number_of_tubes'),
            'sampleValue' => $tankCapacities->value('number_of_samples'),
            'collectionSample' => $samples
        ])
            ->with('tankcapacities', $tankCapacities)
            ->with('storageTanks', $storageTanks)
            ->with('samples', $samples )
        ;
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
    public function show($id)
    {
        //
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
}
