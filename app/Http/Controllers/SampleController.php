<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MaterialType;
use App\Http\Controllers\Post;
use Illuminate\Support\Facades\DB;

class SampleController extends Controller
{
    /**
     * manage samples
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
        // get all the samples
        //$samples = Sample::all();
        $samples = DB::table('sample')
        ->orderBy('storage_date', 'desc')
        ->get();
        // load the view and pass the samples
        return view('sampleList')
            ->with ('samples', $samples)
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // get MaterialTypes
        $material = MaterialType::get('type_of_material');

        // get requests
        $tank_pos   = $request->tank_pos;
        $con_pos    = $request->con_pos;
        $insert_pos = $request->insert_pos;
        $sample_pos = $request->sample_pos;

        // load the create form (app/resources/views/samples.blade.php)
        return view('newSamples')
            ->with('tank_pos', $tank_pos)
            ->with('con_pos', $con_pos)
            ->with('insert_pos', $insert_pos)
            ->with('sample_pos', $sample_pos)
            ->with('material', $material)
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
        // get request
        $tank_pos    = $request->tank_pos;
        $con_pos     = $request->con_pos;
        $insert_pos  = $request->insert_pos;
        $sample_pos  = $request->sample_pos;
        $bnummer     = $request->bnummer;
        $materialtyp = $request->materialtyp;
        $commentary  = $request->commentary;

        // store
        $sample = new sample;
        $sample->B_number           = $bnummer;
        $sample->pos_tank_nr        = $tank_pos;
        $sample->pos_insert         = $con_pos;
        $sample->pos_tube           = $insert_pos;
        $sample->pos_smpl           = $sample_pos;
        $sample->responsible_person = Auth::user()->email;
        $sample->type_of_material   = $materialtyp;
        $sample->commentary         = $commentary;
        $sample->save();

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //TODO: hier fehlt was?

        // delete
        $sample = Sample::where('id','=', $id );
        echo $sample->get();
        $sample->delete();

        // redirect
        return view('home');
    }
}
