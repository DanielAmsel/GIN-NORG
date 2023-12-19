<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class RoleController extends Controller
{
    /**
     * manage roles
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
        // get all the roles
        $roles = Role::all();

        // load the view and pass the roles
        return View::make('roles.index')
            ->with('roles', $roles)
        ;
    }
}
