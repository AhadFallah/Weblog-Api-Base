<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\ImageService;
use App\Http\Requests\ProfileRequest;
use App\Models\Otp;

class ProfileController extends Controller
{
    //edit profile pic
    public function profile(Request $request)
    {
        //get auth user
        $user = auth()->user();

        //validate must be image
        $data = $request->validate([
                    "profile" => 'required|image'
                ]);

        //init ImageService
        $imageService = new ImageService();

        if($user->profile) {
            //delete old profile
            $imageService->deleteImage($user->profile);
        }

        //save the image
        $image = $imageService->setFile($data['profile'])->setPath('images'.DIRECTORY_SEPARATOR.'profiles')->save();

        //profile
        $data['profile'] = $image;

        $user->update($data);

        return response()->json([
            'success' => true
        ]);

    }
    //delete user profile pic
    public function deleteProfile()
    {
        $user = auth()->user();

        $imageService = new ImageService();

        if($user->profile) {
            //delete old profile
            $imageService->deleteImage($user->profile);
        }
        return response()->json([
               'success' => true
           ]);

    }
    public function editProile(ProfileRequest $request)
    {
        $user = auth()->user();
        $data = $request->all();

        //validate data
        $request->validated();

        if($data["email"] != $user->email) {
            //get otp
            $otp = Otp::create([
                "user_id" => $user->id
            ]);

            //send code for email
            //user data should store in cookies and send with verfiaction code to update verify route
            if($otp->sendCode()) {
                return response()->json([
                "code_id" => $otp->id,
                "user_id" => $user->id,
                "user_Data" => $data,
                ]);
            } else {
                //return response for error
                return response()->json([
                    "message" => 'something goes wrong',
                ]);

            }


        } elseif ($data['phone'] != $user->phone) {
            //get otp
            $otp = Otp::create([
                "user_id" => $user->id
            ]);

            //send code for phone
            //user data should store in cookies and send with verfiaction code to update verify route
            if($otp->sendCode()) {
                return response()->json([
                "code_id" => $otp->id,
                "user_id" => $user->id,
                "user_Data" => $data,
                ]);
            } else {
                //return response for error
                return response()->json([
                    "message" => 'something goes wrong',
                ]);

            }



        }
        $user->update($data);
        return response()->json([
            'success' => true
        ]);



    }

}
