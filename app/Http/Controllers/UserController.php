<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{

    function UserRegistration(Request $request){
        try {
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => $request->input('password'),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully'
            ],200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User Registration Failed'
            ],200);

        }
    }

    function UserLogin(Request $request){
        $count=User::where('email','=',$request->input('email'))
            ->where('password','=',$request->input('password'))
            ->count();

        if($count==1){
            // User Login-> JWT Token Issue
            $token=JWTToken::CreateToken($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'User Login Successful',
            ],200)->cookie('token',$token,60*24*30);
        }
        else{
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ],200);

        }

    }
    
    function SendOTPCode(Request $request){

    }
    function VerifyOTP(Request $request){

    }
    function ResetPassword(Request $request){

    }
}
