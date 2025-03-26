<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/auth/saml/login', function () {
    return Socialite::driver('saml2')->redirect();
})->name("saml.login");

Route::match(['get','post'],'/auth/callback', function () {
    $saml = Socialite::driver('saml2')->stateless()->user();

    $user = User::updateOrCreate([
        'email' => $saml->getEmail(),
    ], [
        'u_fname' => $saml->u_fname,
        'u_lname' => $saml->u_lname,
        'auth_type' => 'saml2',
        'password' => bcrypt(\Illuminate\Support\Str::random(32)),
    ]);

    Auth::login($user);

    return redirect('/');
})->withoutMiddleware([VerifyCsrfToken::class])->name('saml.callback');
Route::get('/auth/saml/metadata', function () {
    return Socialite::driver('saml2')->getServiceProviderMetadata();
})->name("saml.metadata");
