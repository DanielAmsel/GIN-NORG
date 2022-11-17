<?php

namespace App\Http\Controllers;

use App\Models\RemovedSample;
use App\Models\Sample;
use App\Models\ShippedSample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RemovedSampleController extends Controller
{
    /**
     * show removed samples
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // get all the removed samples
        $removedSamples = RemovedSample::all();
        $removedSamples = ShippedSample::all();
        $removedSamples = DB::table('removed_sample')
        ->orderBy('removal_date', 'desc')
        ->get();
        // load the view and pass the removed samples
        return view('removedSamples')
            ->with('removedSamples', $removedSamples);
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
        $sampleId  = $request->sample_id;

        // get single data for any sample
        foreach($sample->where('id', $sampleId) as $s)
        {
            $sampleId = $s->id;
            $bnummer  = $s->B_number;
            $material = $s->type_of_material;
            $date     = $s->storage_date;
        }

        $removedSample = new RemovedSample();
        // DB positions
        $removedSample->identifier         = $bnummer;
        $removedSample->responsible_person = Auth::user()->email;
        $removedSample->type_of_material   = $material;
        $removedSample->storage_date       = $date;
        $removedSample->save();

        $toDestroy = Sample::find($sampleId);
        $toDestroy->delete();

        return redirect('/removedSamples');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteSentSample(Request $request)
    {
        $shippedSamples = ShippedSample::all();
        $sampleId  = $request->sample_id;

        foreach ($shippedSamples->where('id', $sampleId) as $shippedSample)
        {
            $shippedSampleId = $shippedSample['id'];
            $shippedSampleIdent = $shippedSample['identifier'];
            $shippedSampleUser = $shippedSample['responsible_person'];
            $shippedSampleTyp = $shippedSample['type_of_material'];
            $shippedSampleDate = $shippedSample['storage_date'];
        }

        $removeShippedSample = new RemovedSample();
        // DB positions
        $removeShippedSample->identifier         = $shippedSampleIdent;
        $removeShippedSample->responsible_person = $shippedSampleUser;
        $removeShippedSample->type_of_material   = $shippedSampleTyp;
        $removeShippedSample->storage_date       = $shippedSampleDate;
        $removeShippedSample->save();

        $toDestroy = ShippedSample::find($shippedSampleId);
        $toDestroy->delete();

        return redirect('/sentSamples');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteSampleFromList(Request $request)
    {
        $samplesDelete = Sample::all();
        $sampleId  = $request->sample_id;

        foreach ($samplesDelete->where('id', $sampleId) as $sampleDelete)
        {
            $samplesDeleteId = $sampleDelete['id'];
            $samplesDeleteIdent = $sampleDelete['B_number'];
            $samplesDeleteUser = $sampleDelete['responsible_person'];
            $samplesDeleteTyp = $sampleDelete['type_of_material'];
            $samplesDeleteDate = $sampleDelete['storage_date'];
            echo 'RemovContr - deleteSampleFromList';
        }

        $removeShippedSample = new RemovedSample();
        // DB positions
        $removeShippedSample->identifier         = $samplesDeleteIdent;
        $removeShippedSample->responsible_person = $samplesDeleteUser;
        $removeShippedSample->type_of_material   = $samplesDeleteTyp;
        $removeShippedSample->storage_date       = $samplesDeleteDate;
        $removeShippedSample->save();

        $toDestroy = Sample::find($samplesDeleteId);
        $toDestroy->delete();

        return redirect('/sampleList');
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
