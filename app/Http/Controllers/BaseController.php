<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function __construct(Request $request)
    {
        $header = $request->header('AppLang');
        app()->setlocale($header);
    }
    //sendrequest
     public function sendRequest($data){
        $response  = [
            'success' => true,
            'data'   => $data,
        ];
        return response()->json($response, 200);
    }

    //senderror
    public function errorRequest($error,$errorMessages = []){
        $response = [
            'success' => false,
            'message' => $error
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response,400);
    }
}
