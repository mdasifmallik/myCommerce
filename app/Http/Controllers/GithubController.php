<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Carbon\Carbon;
use Auth;

class GithubController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();

        if (!User::where('email', $user->getEmail())->exists()) {
            User::insert([
                'name' => $user->getNickname(),
                'email' => $user->getEmail(),
                'role' => 2,
                'password' => Hash::make(40484048),
                'created_at' => Carbon::now()
            ]);
        }


        if (Auth::attempt(['email' => $user->getEmail(), 'password' => 40484048])) {
            return Redirect('/customer/home');
        }

        return back();
    }
}
