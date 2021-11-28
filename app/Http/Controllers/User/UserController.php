<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\QueueUser;
use Validator;
use Hash;
use Auth;

class UserController extends Controller
{
    public function memberlist(){
        $members = User::where('type','member')->get();
        $output = [
            'members' => $members,
            'message' => 'Successfully get member list'
        ];
        return response()->json($output);
    }
    public function adminlist(){
        $admins = User::where('type','admin')->get();
        $output = [
            'admins' => $admins,
            'message' => 'Successfully get admin list'
        ];
        return response()->json($output);
    }

    // @ Create Storage Folder After Register 
    // public function createPath($id){
    //     if(realpath(storage_path('app/public') . '/user_' . $id) == false){
    //         mkdir(storage_path('app/public') . '/user_' . $id, 0777);
    //         mkdir(storage_path('app/public') . '/user_' . $id . '/profile', 0777);
    //         mkdir(storage_path('app/public') . '/user_' . $id . '/book', 0777);
    //         mkdir(storage_path('app/public') . '/user_' . $id . '/book/front_cover', 0777);
    //         mkdir(storage_path('app/public') . '/user_' . $id . '/book/back_cover', 0777);
    //         mkdir(storage_path('app/public') . '/user_' . $id . '/book/inner_images', 0777);
    //     }
    // }

    public function saveMember(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required',
            'password' => 'required'
        ]);
        if($validator->fails()){
            $output = [
                'message' => 'Please Check Again',
                'success' => false
            ];
            return response()->json($output);
        }
       $newuser = new User();
       $newuser->name = $request['name'];
       $newuser->email = $request['email'];
       $newuser->password = Hash::make($request['password']);
       $newuser->type = "member";
       $newuser->save();
       \CreatePath::createStoragePath($newuser->id);

       $output = [
           'message' => 'New Member is successfully registered',
           'success' => true
       ];
       return response()->json($output);
    }

    public function saveSocialMember(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|unique:queue_users',
        ]);
        if($validator->fails()){
            $output = [
                'message' => $validator->errors(),
                'success' => false
            ];
            return response()->json($output);
        }
       $queueUser = new QueueUser();
       $queueUser->email = $request['email'];
       $queueUser->user_id = Auth::user()->id;
       $queueUser->save();

       $output = [
           'message' => 'New Member is successfully registered with Google Account',
           'success' => true
       ];
       return response()->json($output);
    }

    public function saveAdmin(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required',
            'password' => 'required'
        ]);
        if($validator->fails()){
            $output = [
                'message' => 'Please Check Again',
                'success' => false
            ];
            return response()->json($output);
        }
       $newadmin = new User();
       $newadmin->name = $request['name'];
       $newadmin->email = $request['email'];
       $newadmin->password = Hash::make($request['password']);
       $newadmin->type = $request['type'];
       $newadmin->save();
       $output = [
           'message' => 'New '.$request['type'].' is successfully registered',
           'success' => true
       ];
       return response()->json($output);
    }

    // Member Change password
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
}
