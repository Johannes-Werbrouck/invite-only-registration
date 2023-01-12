<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index')->with('users', User::getAllUsers());
    }

    public function destroy(User $user)
    {
        // $this->authorize is not needed here, because the UserPolicy is linked automatically with the 7 CRUD verbs:
        // index, show, create, store, edit, update and delete
        // more info at https://laravel.com/docs/9.x/authorization#registering-policies -> Policy Auto-Discovery
        $user->delete();
        return redirect()->back();
    }

    public function create(CreateUserRequest $request)
    {
        $validated = $request->validated();
        return view('users.create', ['email' => $validated['email'], 'level' => $validated['level']]);
    }

    /**
     * Handle an incoming registration request. This will be called when an invited User accepts the invitation and registers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create($validated);

        event(new Registered($user));

        $user->markEmailAsVerified();

        Auth::login($user);
        //don't forget to import the RouteServiceProvider!
        return redirect(RouteServiceProvider::HOME);
    }
}
