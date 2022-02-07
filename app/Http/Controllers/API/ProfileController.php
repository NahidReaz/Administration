<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Users\ProfileUpdateRequest;
use App\Http\Requests\Users\ChangePasswordRequest;

class ProfileController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

        $this->middleware('auth:api');

    }

    /**
     * Return the user data
     *
     * @return \Illuminate\Http\Response
     */

     public function profile(){

        $response = [
            'success' => true,
            'data' => auth('api')->user(),
            'message' => 'User Profile',
        ];

        return response()->json($response, 200);

     }

     /**
     * Update the profile by users
     *
     * @param  \App\Http\Requests\Users\ProfileUpdateRequest  $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */

     public function updateProfile(ProfileUpdateRequest $request){

        $user = auth('api')->user();
        $user->update($request->all());

        $response = [
            'success' => true,
            'data' => $user,
            'message' => 'Profile updated'
        ];

        return response()->json($response,200);
     }

     /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Users\ChangePasswordRequest  $request
     *
     * @return \Illuminate\Http\Response
     */

     public function changePassword(ChangePasswordRequest $request){

        User::find(auth('api')->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        $response = [
            'success' => true,
            'data' => [],
            'message' => ' Password updated'
        ];

        return response()->json($response,200);
     }

}
