<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Symfony\Component\Console\Input\Input;

class ManageUserController extends Controller
{
    /**
     * manage users
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
        // get all the roles
        $users = User::all();

        // load the view and pass the roles
        return View::make('users.index')
            ->with('users', $users)
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all('id','name', 'email', 'role');
        $roles = Role::all('role_name');

        return view('manageUser')
            ->with('users', $users)
            ->with('roles', $roles);

    }

    public function updateRights(Request $request)
    {
        $user = User::find($request->id);
        $user->role = $request->role;

        if ($user->role !== null) {
            $user->update();
        }

        return redirect('/manageUser');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // do we need a validation of the user?
        //TODO: muss noch getestet werden

        // store
        $user = new user;
        $user->name                 = Input::get('name');
        $user->email                = Input::get('email');
        $user->email_verified_at    = date_timestamp_get();
        $user->password             = Input::get('password');
        $user->role                 = ('Default');
        $user->save();

        // redirect
        return redirect('user'); //TODO: Login oder Home muss als return hin
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get the user
        $user = User::find($id);

        // show the view and pass the role to it
        return View('users')
            ->with('user', $user)
        ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the user
        $user = User::find($id);

        // show the edit form and pass the user
        return View::make('users.edit')
            ->with('user', $user)
        ;
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
        // store
        //TODO: Müssten im Update bei uns eigentlich nicht die role geupdated werden?
        $user = User::find($id);
        $user->username  = Input::get('username');
        $user->email     = Input::get('email');
        $user->password  = Input::get('password');
        $user->role      = Input::get('role');
        $user->save();

        // redirect
        Session::flash('message', 'Benutzer wurde erfolgreich aktualisiert!');
        return redirect('user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        // delete TODO muss noch implementiert werden mit benutzer verwaltung
        $user = User::find($request->id);
        $user->delete();

        // redirect
      
        return redirect('/');
    }
}
