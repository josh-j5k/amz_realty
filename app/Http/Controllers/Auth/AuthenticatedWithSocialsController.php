<?php

namespace App\Http\Controllers\Auth;

use Carbon\Traits\Timestamp;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedWithSocialsController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider)
    {
        $socialiteUser = Socialite::driver($provider)->user();


        if (User::where('provider_id', $socialiteUser->getId())->exists()) {
            $user_arr = User::where('provider_id', $socialiteUser->getId())->first();
            Auth::login($user_arr);
            Session::regenerate();
            return redirect()->route('user.dashboard',  $socialiteUser->getId());
        } else if (User::where('email', $socialiteUser->getEmail())->exists()) {
            $user_arr = User::where('email', $socialiteUser->getEmail())->first();
            Auth::login($user_arr);
            Session::regenerate();
            return redirect()->route('user.dashboard',  $socialiteUser->getId());
        } else {

            $user = User::updateOrCreate([

                'name' => $socialiteUser->getName(),
                'email' => $socialiteUser->getEmail(),
                'avatar' => $socialiteUser->getAvatar(),
                'provider_id' => $socialiteUser->getId(),
                'provider' => $provider

            ]);
            $user->markEmailAsVerified();
            Auth::login($user);

            return redirect()->intended('user.dashboard',  $socialiteUser->getId());
        }
    }
}
