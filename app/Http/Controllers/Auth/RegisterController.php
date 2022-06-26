<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle the incoming registrationrequest.
     */

    //  public function register(Request $request)
    //  {
    //      $request->validate([
    //         'name' => 'required|string|max:255',
    //         'username' => 'required|string|max:255|unique:users',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //      ]);

    //         Auth::login($user = User::create([
    //             'name' => $request->name,
    //             'username' => $request->username,
    //             'email' => $request->email,
    //             'password' => bcrypt($request->password),
    //         ]));

    //         event(new Registered($user));

    //         return response()->json([
    //             'message' => 'Registration successful',
    //         ], 200);
    //  }

    public function __invoke()
    {
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'username' => request('username'),
            'password' => Hash::make(request('password')),
        ]);

        Auth::guard('web')->login($user);
    }
}
