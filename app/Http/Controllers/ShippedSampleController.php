<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use App\Models\ShippedSample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Fhir\FhirClient;
use App\Fhir\FhirService;
use App\Fhir\LocationResourceActiveSample;

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
        $shippedSamples = DB::table('shipped_sample')
        ->orderBy('shipping_date', 'desc')
        ->get();

        // load the view and pass the shipped samples
        return view('sentSamples')
            ->with('shippedsample', $shippedSamples)
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
        $sample     = Sample::all();
        $identifier = null;
        $material   = null;
        $date       = null;
        $address    = $request->address;
        $sampleId   = $request->sample_id;

        // get data per id of any sample
        foreach($sample->where('id', $sampleId) as $s)
        {
            $sampleId = $s->id;
            $identifier = $s->identifier;
            $material = $s->type_of_material;
            $date     = $s->storage_date;
        }

        $shippedSample = new ShippedSample();

        $shippedSample->identifier         = $identifier;
        $shippedSample->responsible_person = Auth::user()->email;
        $shippedSample->type_of_material   = $material;
        $shippedSample->storage_date       = $date;
        $shippedSample->shipped_to         = $address;
        $shippedSample->save();

        $toDestroy = Sample::find($sampleId);
        $toDestroy->delete();

        if (config('fhir.fhir.enabled')) {
            $request->merge(['action' => 'update', 'identifier' => $shippedSample['identifier'], 'materialtyp' => $shippedSample['type_of_material']]);

            $fhirService = new FhirService();
            $fhirService->sendToFhirServer($request);
        }

        return redirect('/sentSamples');
    }
}
