<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {

        $name = $request->input('name');
        $email = $request->input('email');
        $username = $request->input('username');
        $password = Hash::make($request->input('password'));

        // elquent
        $register = User::create([
            'name' => $name,
            'email' => $email,
            'username' => $username,
            'password' => $password,
        ]);

        if($register)
        {
            return response()->json([
                'success' => true,
                'message' => 'Register Success!',
                'data' => [
                    'user' => $register,
                ]
            ],201);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Register Fail!',
                'data' => ''
            ],400);
        }
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if(Hash::check($password, $user->password))
        {
            $apiToken = base64_encode(str_random(40));

            $user->update([
                'api_token' => $apiToken
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Login Success',
                'data' => [
                    'user' => $user,
                    'api_token' => $apiToken
                ]
            ], 201);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Login unsuccess',
                'data' => ''
            ],400);
        }
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $user = User::where('id', $id)->first();


        $name = $request->input('name');
        $email = $request->input('email');
        $username = $request->input('username');

        $image_url = $request->input('image_url');

        $password = Hash::make($request->input('password'));

        $stateUpdate = $request->input('stateUpdate');

        /**
        * 0 update password - stateUpdate
        * 1 no update password - stateUpdate
        * 2 update profile photo only
        */
        if($stateUpdate == "0"){ // 0 update password - stateUpdate
            // elquent
            $user->update([
                        'name' => $name,
                        'email' => $email,
                        'username' => $username,
                        'password' => $password
                    ]);
        } elseif($stateUpdate == "2"){ // 2 update profile photo only
            // elquent
            $user->update([
                        'image_url' => $image_url
                    ]);
        } else { // 1 no update password - stateUpdate
            // elquent
            $user->update([
                        'name' => $name,
                        'email' => $email,
                        'username' => $username
                    ]);
        }

        if($user)
           {
            return response()->json([
                'success' => true,
                'message' => 'Update Success',
                'data' => [
                    'user' => $user
                ]
            ], 201);
        }
        else {
            return response()->json([
                    'success' => false,
                    'message' => '',
                    'data' => [
                        'user' => ''
                    ]
                ], 400);
        }
    }

    public function upload(Request $request)
    {
        # code...
        $filefoto = $request->input('file');

        $target_dir = "uploads/";
        $target_file_name = $target_dir.basename($_FILES["file"]["name"]);
        $response = array();

        if(isset($_FILES["file"])){

            if(move_uploaded_file($_FILES["file"]["tmp_name"],$target_file_name)){
                $success = true;
                $message = "Uploaded!!!";
                $url = $target_file_name;
                // $url = $_FILES["file"]["name"];
            } else {
                $success = false;
                $message = "NOT Uploaded!!! _ Error While Uploading";
            }
        } else {
            $success = false;
            $message = "missing field";
        }

        $response["success"] = $success;
        $response["message"] = $message;
        $response["url"] = $url;
        echo json_encode($response);

    }

}
