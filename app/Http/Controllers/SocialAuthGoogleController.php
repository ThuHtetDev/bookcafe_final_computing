<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Services\SocialGoogleAccountService;
use App\User;
use App\QueueUser;
use App\SocialInfo;
use Hash;
use Auth;

class SocialAuthGoogleController extends Controller
{
    /**
   * Create a redirect method to google api.
   *
   * @return void
   */
  public function redirect()
  {
    return Socialite::with('google')->redirectUrl('http://localhost:8000/callback')->redirect();
    //   return Socialite::driver('google')->redirect();
  }
    /**
   * Return a callback method from google api.
   *
   * @return callback URL from google
   */
  public function callback()
  {
    try {
        $user = Socialite::driver('google')->redirectUrl('http://localhost:8000/callback')->stateless()->user();
        // $user = Socialite::driver('google')->user();
    } catch (\Exception $e) {
        return redirect('/login');
    }


    // check if existing user exist in Queue User Table
    $existingUser = QueueUser::where('email', $user->email)->first();
    if($existingUser){
        $newUser = new User();
        $newUser->name = $user->name;
        $newUser->email = $user->email;
        $newUser->password = Hash::make('12345');
        $newUser->type = "member";
        $newUser->save();
        \CreatePath::createStoragePath($newUser->id);

        $userSocialInfo = new SocialInfo();
        $userSocialInfo->user_id = $newUser->id;
        $userSocialInfo->uid = $user->id;
        $userSocialInfo->uname = $user->name;
        $userSocialInfo->avatar = $user->avatar;
        $userSocialInfo->save();
        
        auth()->login($newUser, true);
    }else{
        $currentUser = User::where('email', $user->email)->first();
        if($currentUser){
            auth()->login($currentUser, true);
        }else{
            $newUser = new User();
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->password = Hash::make('12345');
            $newUser->type = "member";
            $newUser->save();
            \CreatePath::createStoragePath($newUser->id);
    
            $userSocialInfo = new SocialInfo();
            $userSocialInfo->user_id = $newUser->id;
            $userSocialInfo->uid = $user->id;
            $userSocialInfo->uname = $user->name;
            $userSocialInfo->avatar = $user->avatar;
            $userSocialInfo->save();
            
            auth()->login($newUser, true);
        }
    }
   
    return redirect()->to('/home');
  }
}
