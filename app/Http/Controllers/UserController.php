<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResetPasswordMail;
use App\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function sendResetToken(Request $request)
    {
        //VALIDASI EMAIL UNTUK MEMASTIKAN BAHWA EMAILNYA SUDAH ADA
        $this->validate($request, [
            'email' => 'required|email|exists:users'
        ]);

        $apiToken = base64_encode(str_random(40));

        //GET DATA USER BERDASARKAN EMAIL TERSEBUT
        $user = User::where('email', $request->email)->first();
        //LALU GENERATE TOKENNYA
        $user->update([
            'remember_token' => $apiToken,
        ]);

        //kirim token via email sebagai otentikasi kepemilikan
        Mail::to($user->email)->send(new ResetPasswordMail($user));

        return response()->json([
            'status' => true,
            'message' => 'token telah dikirim',
            'token' => $user->remember_token
        ], 200);
    }

    public function verifyResetPassword(Request $request)
    {
        $rememberToken = $request->input('remember_token');

        //VALIDASI EMAIL UNTUK MEMASTIKAN BAHWA EMAILNYA SUDAH ADA
        $this->validate($request, [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6'
        ]);

        //GET DATA USER BERDASARKAN EMAIL TERSEBUT
        $user = User::where('email', $request->email)->first();

        if ($user->remember_token == $rememberToken) {
            # code...
            //UPDATE PASSWORD USER TERKAIT
            $user->update([
                'password' => Hash::make($request->password),
                'remember_token' => ""
                ]
            );
            if($user){
                return response()->json([
                    'status' => true,
                    'message' => 'change password success',
                    'data' =>  [
                            'user' => $user
                        ]
                ], 200);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'token salah',
                'data' =>  [
                        'user' => ""
                    ]
            ], 400);
        }

    }
}
