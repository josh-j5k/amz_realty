<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
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


        $finduser_by_id = User::where('provider_id', $socialiteUser->getId());
        $finduser_by_email = User::where('email', $socialiteUser->getEmail());
        if ($finduser_by_id) {
            Auth::login($finduser_by_id);

            return redirect()->intended(RouteServiceProvider::HOME);
        } else if ($finduser_by_email) {
            Auth::login($finduser_by_email);
            return redirect()->intended(RouteServiceProvider::HOME);
        } else {

            $user = User::updateOrCreate([

                'name' => $socialiteUser->getName(),

                'email' => $socialiteUser->getEmail(),

                'provider_id' => $socialiteUser->getId(),
                'provider' => $provider

            ]);
            Auth::login($user);

            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }
}
