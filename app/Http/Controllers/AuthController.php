<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Auth;


class AuthController extends Controller
{
    public function socialredirect($provider,$role)
    {
        session(['auth_role' => $role]);
        return Socialite::driver($provider)->redirect();
    }
    
    public function handlesociallogin($provider,Request $request)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
            $role = session('auth_role');
            session()->forget('auth_role');
            $user = user::where('auth_provider_id',$socialUser->id)->first();
            if($role == "customer")
            {
                if($user)
                {
                    Auth::login($user);
                    return redirect()->route('home');
                }else{
                    $userData = User::create([
                        'name' => $socialUser->name,
                        'email' => $socialUser->email,
                        'password' => bcrypt(12345678),
                        'auth_provider' => $socialUser->id,
                        'auth_provider_id' => $provider,
                        'role' => 2
                        ]);
                        
                    if($userData)
                    {
                        Auth::login($userData);
                        return redirect()->route('home');
                    }
                }
            }elseif($role == "vendor")
            {
                if($user)
                {
                    Auth::login($user);
                    return redirect('https://dealsmachi.com/dealsmachiVendor');
                }else{
                    $userData = User::create([
                        'name' => $socialUser->name,
                        'email' => $socialUser->email,
                        'password' => bcrypt(12345678),
                        'auth_provider' => $socialUser->id,
                        'auth_provider_id' => $provider,
                        'role' => 3
                        ]);
                        
                    if($userData)
                    {
                        Auth::login($userData);
                        return redirect('https://dealsmachi.com/dealsmachiVendor');
                    }
                }
            }
        }catch (InvalidStateException $e) {
            return redirect('/login')->withErrors(['msg' => 'The authentication process was tampered with. Please try again.']);
        } catch (ClientException $e) {
            // Log the exact response from Google
            Log::error('Google OAuth Error: ', [
                'message' => $e->getMessage(),
                'response' => $e->getResponse()->getBody()->getContents(),
            ]);
        
            return redirect('/login')->withErrors(['msg' => 'Authentication failed with Google. Please try again.']);
        } catch (Exception $e) {
            Log::error('General Google OAuth Error: '.$e->getMessage());
        
            return redirect('/login')->withErrors(['msg' => 'An error occurred. Please try again.']);
        }
        
        
        
       
    }
}
