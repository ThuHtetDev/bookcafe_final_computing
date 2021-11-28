<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use Carbon\Carbon;
use DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $newUser = new User;
        $newUser->name = $request['name'];
        $newUser->email = $request['email'];
        $newUser->type  = $request['type'];
        $newUser->password = Hash::make($request['password']);
        $newUser->save();

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials)){
             return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('authToken');
        $token = $tokenResult->token;
        if ($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();

        $output = [
            'uid' => '',
            'email' => $user->email,
            'name' => $user->name,
            'profile' => 'http://book-cafe.sitetastingmyanmar.com/images/male_user.png',
            'isAdmin' => $user->type != 'member' ? '1' : '0',
            'lang' => $user->lang,
            'bearToken' => $tokenResult->accessToken,
        ];
        return response()->json($output,200);
    }

    
    public function logout(Request $request){
        $authAccessToken = Request()->user()->token();
        DB::table('oauth_refresh_tokens')->where('access_token_id', $authAccessToken->id)
                                         ->update(['revoked'=> true]);
        $authAccessToken->revoke();
        return response('success', 200);
    }
}
