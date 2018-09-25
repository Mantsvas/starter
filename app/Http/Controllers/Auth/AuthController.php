<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;

class AuthController extends Controller
{
    public function redirectToProvider($provider)
    {

        return Socialite::driver($provider)->redirect();
    }
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        return $user->token;
    }
}
