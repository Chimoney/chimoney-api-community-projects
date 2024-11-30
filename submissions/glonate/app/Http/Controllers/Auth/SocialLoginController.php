<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccountService;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{

    public function redirectFacebook(){
        //dd(url('login/facebook-callback'));
        return Socialite::driver('facebook')->redirect();
    }

    public function callbackFacebook(SocialAccountService $service){
        try {
            $fb_user = Socialite::driver('facebook')->user();
            $user = $service->createOrGetFBUser($fb_user);
            auth()->login($user);
            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e){
            return redirect(route('login'))->with('error',$e->getMessage());
        }
    }



    public function redirectGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle(SocialAccountService $service){
        try {
            $fb_user = Socialite::driver('google')->user();
            $user = $service->createOrGetGoogleUser($fb_user);
            auth()->login($user);
            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e){
            return redirect(route('login'))->with('error', $e->getMessage());
        }
    }  
    
    
}
