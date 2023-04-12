<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Post;
use App\Models\ShippedSample;

class RestoreSampleController extends Controller
{
    /**
     * show restored samples
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
        //this is pregenerated stub, can be used later if features are to be implemented
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $shippedSamples = ShippedSample::all();

        //get request
        $tank_pos = $request->tank_pos;
        $con_pos = $request->con_pos;
        $tube_pos = $request->tube_pos;
        $sample_pos = $request->sample_pos;

        // load the create form (app/resources/views/samples.blade.php)
        return view('restoreSample')
            ->with('tank_pos', $tank_pos)
            ->with('con_pos', $con_pos)
            ->with('tube_pos', $tube_pos)
            ->with('sample_pos', $sample_pos)
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
        // store
        $sample = new sample;

        //Postion in database schreiben
        $sample->pos_tank_nr = $request->tank_pos;
        $sample->pos_insert  = $request->con_pos;
        $sample->pos_tube    = $request->tube_pos;
        $sample->pos_smpl    = $request->sample_pos;

        //Info data
        $sample->identifier           = $request->identifier;
        $sample->responsible_person = Auth::user()->email;
        $sample->type_of_material   = $request->material;

        $sample->save();

        $toDestroy = ShippedSample::find($request->id);

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
        // delete
        $sample = Sample::where('id','=', $id );
        echo $sample->get();
        $sample->delete();

        // redirect
        return redirect('sentSamples');
    }
}
