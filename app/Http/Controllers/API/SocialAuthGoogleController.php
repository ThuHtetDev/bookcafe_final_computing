<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
    //   dd(Socialite::with('google')->redirect()->getTargetUrl());
    return Socialite::with('google')->redirectUrl('http://localhost:8000/api/callback')->redirect();
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
        $user = Socialite::driver('google')->redirectUrl('http://localhost:8000/api/callback')->stateless()->user();
    } catch (\Exception $e) {
        return response()->json(['message' => 'cannot get user permission']);   
    }
    // check if existing user exist in Queue User Table
    $existingUser = QueueUser::where('email', $user->email)->first();
    if($existingUser){
    // If google acc user is authenticated,
    // ! First Time Login For User
    // (1) queue user has used == 1
    // (2) add user info into Users table
    // (3) add user info into Social Info table
    // (4) create path for user images
        if($existingUser->has_used == '0'){
            $existingUser->has_used = '1';
            $existingUser->save();
    
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

            $tokenResult = $newUser->createToken('authToken');

            $result = [
                'uid'     => $user->id,
                'email'   => $user->email,
                'name'    => $user->name,
                'nickName'=> $user->nickname,
                'profile' => $user->avatar,
                'isAdmin' => $newUser->type == 'member' ? '0' : '1',
                'lang'    => $newUser->lang,
                'access_token' => $tokenResult->accessToken
            ];

            return response()->json($result);

        }else{
            // ! Another Login Time For User
            $currentUser = User::where('email', $user->email)->first();
            if($currentUser){
            $tokenResult = $currentUser->createToken('authToken');
            $token = $tokenResult->token;
            $result = [
                'uid'     => $user->id,
                'email'   => $user->email,
                'name'    => $user->name,
                'nickName'=> $user->nickname,
                'profile' => $user->avatar,
                'isAdmin' => $currentUser->type == 'member' ? '0' : '1',
                'lang'    => $currentUser->lang,
                'access_token' => $tokenResult->accessToken
            ];
            return response()->json($result);
            }else{
                return response()->json(['message' => 'user unauthenticated']);
            }
        }
    } else {
       $output = [
           'unauthenticated' => true
       ];
       return response()->json($output);
    }
    return response()->json($existingUser);

  }
}
