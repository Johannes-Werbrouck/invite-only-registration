<?php

namespace App\Http\Controllers;

use App\Enums\UserLevel;
use App\Http\Requests\StoreUserInviteRequest;
use App\Models\User;
use App\Notifications\UserInvited;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class UserInviteController extends Controller
{
    public function create()
    {
        $this->authorize('invite', User::class);
        return view('userinvites.create');
    }

    public function store(StoreUserInviteRequest $request)
    {
        $validated = $request->validated();

        // The enum validation will check if the chosen level can be cast to a UserLevel, but won't do the casting itself. So we do it here
        $userLevel = UserLevel::from($validated['level']);
        $email = $validated['email'];

        // send mail to invite the new user with the given user level.
        try
        {
            Notification::route('mail', $email)->notify(new UserInvited($userLevel, $request->user()));
        }
        catch( \Exception $e)
        {
            return redirect('/users')->with('error', "<b>Oh no!</b> Something went wrong. Please try again later.");
        }
        return redirect('/users')->with('success', "<b>Success!</b> An invite with level $userLevel->name has been sent to $email.");
    }
}
