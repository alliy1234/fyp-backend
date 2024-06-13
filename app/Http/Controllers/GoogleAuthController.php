<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleAuthController extends Controller
{
    // Redirect the user to the Google authentication page
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Obtain the user information from Google
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        // Use $user to authenticate the user or create a new user record
        $authenticatedUser = User::firstOrCreate(
            ['email' => $user->getEmail()],
            ['name' => $user->getName(), 'password' => bcrypt('password')]
        );

        Auth::login($authenticatedUser);

        return response()->json([
            'user' => $user
        ]);
    }
}
