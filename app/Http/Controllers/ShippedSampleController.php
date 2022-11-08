<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use App\Models\ShippedSample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippedSampleController extends Controller
{
    /**
     * manage shipped samples
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
        // get all the shipped samples
        $shippedSamples = ShippedSample::all();

        // load the view and pass the shipped samples
        return view('sentSamples')
            ->with('shippedsample', $shippedSamples)
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
        $sample    = Sample::all();
        $bnummer   = null;
        $material  = null;
        $date      = null;
        $sampleId = $request->sample_id;

        // get data per id of any sample
        foreach($sample->where('id', $sampleId) as $s)
        {
            $sampleId = $s->id;
            $bnummer  = $s->B_number;
            $material = $s->type_of_material;
            $date     = $s->storage_date;
        }

        $shippedSample = new ShippedSample();

        $shippedSample->identifier         =  $bnummer;
        $shippedSample->responsible_person = Auth::user()->email;
        $shippedSample->type_of_material   = $material;
        $shippedSample->storage_date       = $date;
        $shippedSample->shipped_to         = "Afrika";
        $shippedSample->save();

        $toDestroy = Sample::find($sampleId);
        $toDestroy->delete();

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //???
    }
}
