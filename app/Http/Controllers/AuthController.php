<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Auth;


class AuthController extends Controller
{
    public function socialLogin($socialprovider)
    {
        return Socialite::driver($socialprovider)->redirect();
    }

    public function socailLoginResponse($socialprovider)
    {
        try {
            $user = Socialite::driver($socialprovider)->user();
            $finduser = User::where('auth_provider',$socialprovider)->where('auth_provider_id', $user->id)->first();
            if($finduser){
                Auth::login($finduser);
                return redirect()->intended('home');
                
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'auth_provider_id'=> $user->id,
                    'auth_provider' => $socialprovider,
                    'password' => encrypt('12345678')
                    ]);
                    Auth::login($newUser);
                    return redirect()->intended('home');
                }
            } catch (Exception $e) {
    
                $e->getMessage();
    
            }
    }
}
