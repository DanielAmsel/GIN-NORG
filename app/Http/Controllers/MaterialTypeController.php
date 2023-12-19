<?php

namespace App\Http\Controllers;

use App\Models\MaterialType;
use App\Models\Sample;
use Illuminate\Http\Request;


class MaterialTypeController extends Controller
{
    /**
     * Create MaterialType
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
        $allSamplesinTank = Sample::all();
        // get MaterialTypes
        $material = MaterialType::all();


        // load the create form (app/resources/views/samples.blade.php)
        return view('materialType')
            ->with('material', $material)
            ->with('allSamplesinTank', $allSamplesinTank)
        ;

    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'newMaterial' => 'required|unique:material_types,type_of_material'
        ]);

        $materialType = new MaterialType();
        $materialType->type_of_material = $request->input('newMaterial');
        $materialType->save();

        return redirect('/manageMaterialTypes')->with('success', __('messages.Materialtyp wurde hinzugefügt!'));

    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        $materialType = MaterialType::find($request->material_id);
        $materialType->delete();

        // redirect
        return redirect('/manageMaterialTypes')->with('success', __('messages.Materialtyp wurde entfernt!'));
    }
}
