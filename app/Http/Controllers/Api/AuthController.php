<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Http\Requests\AuthRequest;
use  App\Http\Requests\SigninRequest;
use  App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\Otp;

class AuthController extends Controller
{
    //regisetr the user and send the verify code for login
    //
    //@* @param all user info
    //@return code_id and user_id
    //
    public function register(AuthRequest $request)
    {
        $request->wantsJson();

        //get data
        $data = $request->all();

        //validate the data
        $request->validated();

        //create a user
        $user = User::create($data);

        //send code for login
        $otp = Otp::create([
            "user_id" => $user->id
        ]);
        if($otp->sendCode()) {
            return response()->json([
            "code_id" => $otp->id,
            "user_id" => $user->id,
            ]);
        }

        //return response for error
        return response()->json([
            "message" => 'something goes wrong',
        ]);
    }
    // ########################################################################################
    //
    //
    //@* @param connection (email or phone number)
    //@return code_id and user_id
    //
    //
    //resend the code for login
    public function login(SigninRequest $request)
    {
        //get data
        $data = $request->all();

        //validate data
        $request->validated();

        //if is email
        if(filter_var($data['connection'], FILTER_VALIDATE_EMAIL)) {
            //get user by email
            $user = User::where('email', $data['connection'])->first();


            //check if user exists
            if(!$user) {
                return response()->json([
                    "message" => "user not exists",
                ]);

            }
            //get otp
            $otp = Otp::create([
                "user_id" => $user->id
            ]);

            //send code for email
            if($otp->sendCode()) {
                return response()->json([
                "code_id" => $otp->id,
                "user_id" => $user->id,
                ]);
            }

            //return response for error
            return response()->json([
                "message" => 'something goes wrong',
            ]);

        }

        //get user by phone
        $user = User::where('phone', $data['connection'])->get();


        //check if user exists
        if($user->isEmpty()) {
            return response()->json([
                "message" => "user not exists",
            ]);

        }

        //get otp
        $otp = Otp::create([
            "user_id" => $user->id
        ]);
        //send code for phone
        if($otp->sendCode()) {
            return response()->json([
            "code_id" => $otp->id,
            "user_id" => $user->id,
            ]);
        }

        //return response for error
        return response()->json([
            "message" => 'something goes wrong',
        ]);
    }
    // ########################################################################################
    //
    //@* @param code_id user_id code
    //@return token and user
    //
    //
    //verify the code
    public function verify(LoginRequest $request)
    {
        //get data
        $data = $request->all();

        //validate data
        $request->validated();


        //get the opt object
        $otp = Otp::where('user_id', $data["user_id"])->find($data["code_id"]);

        //handle errors
        if(!$otp) {
            return response()->json([
                'message' => "something is not right"
            ]);
        }
        if(!$otp->isValid()) {
            return response()->json([
                            'message' => "The code is either expired or used."
                        ]);
        }
        if($otp->code !== $data['code']) {
            return response()->json([
                'message' => "code is wrong"
            ]);

        }
        //make the otp token used
        $otp->update([
        'used' => true
    ]);
        //find user
        $user = User::find($data['user_id']);

        //generate santum token
        $token = $user->createToken($user->name.-'AuthToken')->plainTextToken;

        //return token
        return response()->json([
            'token' => $token,
            'user' => $user
        ]);


    }
    // ########################################################################################
    //
    //@* @param accesstoken
    //@return strinng
    //
    //
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            "message" => "logged out"
        ]);
    }

    ///##############################################################################################
    //verify the code
    public function verifyUpdate(LoginRequest $request)
    {
        //get data
        $data = $request->all();

        //validate data
        $request->validated();


        //get the opt object
        $otp = Otp::where('user_id', $data["user_id"])->find($data["code_id"]);

        //handle errors
        if(!$otp) {
            return response()->json([
                'message' => "something is not right"
            ]);
        }
        if(!$otp->isValid()) {
            return response()->json([
                            'message' => "The code is either expired or used."
                        ]);
        }
        if($otp->code !== $data['code']) {
            return response()->json([
                'message' => "code is wrong"
            ]);

        }
        //make the otp token used
        $otp->update([
        'used' => true
    ]);
        //find user
        $user = auth()->user();

        $user->update($data['user_data']);

        //return token
        return response()->json([
            'success' => true
        ]);


    }



}
