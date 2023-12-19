<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Symfony\Component\Console\Input\Input;
use App\Models\ManageUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


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

    /**
     * Update a user's role.
     *
     * Finds and updates the role of a user based on the provided request data.
     * The update is performed only if the new role is not null.
     * Redirects to the user management page with a success message after update.
     *
     * @param  \Illuminate\Http\Request  $request Request containing user ID and new role.
     * @return \Illuminate\Http\RedirectResponse Redirects to the manageUser page with a success message.
     */
    public function updateRights(Request $request)
    {
        $user = User::find($request->id);
        $user->role = $request->role;

        if ($user->role !== null) {
            $user->update();
        }

        return redirect('/manageUser')->with('success', __('messages.Benutzerrolle wurde aktualisiert'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $user = new user;
        $user->name                 = Input::get('name');
        $user->email                = Input::get('email');
        $user->email_verified_at    = date_timestamp_get();
        $user->password             = Input::get('password');
        $user->role                 = ('Default');
        $user->save();

        // redirect
        return redirect('user');
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
        $user = User::find($id);
        $user->username  = Input::get('username');
        $user->email     = Input::get('email');
        $user->password  = Input::get('password');
        $user->role      = Input::get('role');
        $user->save();

        // redirect
        return redirect()->back()->with('success', __('messages.Benutzerrolle wurde aktualisiert'));
    }


    /**
     * Display confirmation view for user deletion.
     *
     * Retrieves the user by the provided ID from the request and returns a view
     * to confirm the deletion of the user.
     *
     * @param  \Illuminate\Http\Request  $request Request containing the user ID.
     * @return \Illuminate\Contracts\View\View Returns the 'confirm-delete' view with user data.
     */
    public function confirmDelete(Request $request)
    {
        $user = User::find($request->id);
        
        // return the confirm-delete view with user data
        return view('confirm-delete', compact('user'));
    }

    /**
     * Delete the user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(Request $request)
    {
        $user = User::find($request->id);

        try {
            $user->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1451) {
                // foreign key constraint violation error
                return redirect('/manageUser')->with('error', __('messages.Von diesem Benutzer sind existente Proben angelegt bzw. sind aktuell Proben versendet worden. Er kann nicht gelöscht werden'));
            }
        }
        
        // redirect
        return redirect('/manageUser')->with('success', __('messages.Benutzer wurde gelöscht'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function resetPassword(Request $request)
    {
        $authenticatedUserId = Auth::id();

        $user = User::findOrFail($request->id);
            
        $newPassword = $request->input('new_password');
        
        // check if pw is empty
        if (empty($newPassword)) {
            return redirect('/manageUser')->with('error', __('messages.Das Passwortfeld darf nicht leer sein!'));
        }
        
        // reset pw of user
        $manageUser = new ManageUser();
        $manageUser->resetPassword($user, $newPassword);

        // show message
        return redirect('/manageUser')->with('success', __('messages.Passwort wurde erfolgreich zurückgesetzt!'));
    }
}
