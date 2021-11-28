<?php

namespace App\Http\Controllers\API\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    public function login(Request $request){
        $uid = $request->get('uid');
        $email = $request->get('email');
        $profile = $request->get('profile');
        $hasQueue = true;

        $user = new User();
        

        return 'success';
    }
}
