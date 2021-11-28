<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;

class UserController extends Controller
{
    public function getUser(){
        $users = User::all();
        return response()->json($users);
    }

    public function changePassword(Request $request){
        $authUser = User::find(Auth::user()->id);
        $current_password = $authUser->password;
        if(Hash::check($request['old_pass'], $current_password))
        {
            $authUser->password =  Hash::make($request['new_pass']);
            $authUser->save();
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    // @ change profile name
    public function changeProfile(Request $request){
        $authUser = User::find(Auth::user()->id);
        if($authUser){
            if(!is_null($request->name)) $authUser->name = $request->name;
            if(!is_null($request->lang)) $authUser->lang = $request->lang;
            $authUser->save();
            return response("success",200);
        }
    }

    public function authUser(Request $request){
    
        $result = [
            "uid"   => is_null($request->user()->userInfo) ? '' :  $request->user()->userInfo->uid,
            'id'    => $request->user()->id,
            "email" => $request->user()->email,
            "name"  => $request->user()->name,
            "profile" => "http://book-cafe.sitetastingmyanmar.com/images/male_user.png",
            "isAdmin" => $request->user()->type != 'member' ? '1' : '0',
            "lang"=> $request->user()->lang,
        ];
        return response()->json($result,200);
    }
}
