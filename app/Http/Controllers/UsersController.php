<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use SmsManager;

class UsersController extends Controller
{
    public function validatePhone(Request $request)
    {
        $rules = [
            'phone' => 'required|regex:/(1)[0-9]{10}/'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $rules = [
            'phone' => 'unique:users'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 201);
        }
        return response()->json('success', 200);
    }

    public function validateCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile'     => 'required|confirm_mobile_not_change|confirm_rule:mobile_required',
            'verifyCode' => 'required|verify_code',
        ]);
        if ($validator->fails()) {
           SmsManager::forgetState();
           return response()->json($validator->errors(), 400);
        }

        $phone = $request->input('mobile');
        $user = User::create(['phone'=>$phone]);
        $token = $user->createToken('live_air')-> accessToken;

        return response()->json($token, 200);
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile'     => 'required|confirm_mobile_not_change|confirm_rule:mobile_required',
            'verifyCode' => 'required|verify_code',
        ]);
        if ($validator->fails()) {
           SmsManager::forgetState();
           return response()->json($validator->errors(), 400);
        }

        $phone = $request->input('mobile');

        $user = User::where('phone', $phone)->first();
        if ($user) {
            $token = $user->createToken('live_air')-> accessToken;
        }else{
            $user = User::create(['phone'=>$phone]);
            $token = $user->createToken('live_air')-> accessToken;
        }
        $data = ['token' => $token,
                 'user'  => $user,
                ];
        return response()->json($data, 200);
    }

    public function loginCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile'     => 'required|confirm_mobile_not_change|confirm_rule:mobile_required',
            'verifyCode' => 'required|verify_code',
        ]);
        if ($validator->fails()) {
           SmsManager::forgetState();
           return response()->json($validator->errors(), 400);
        }

        $phone = $request->input('mobile');
        $user = User::where('phone', $phone)-> first();
        $token = $user->createToken('live_air')-> accessToken;

        return response()->json($token, 200);

    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->update($request->all());
        return response()->json($user, 200);
    }

    public function details()
    {
        $user = Auth::user(); 
        return response()->json($user, 200); 
    }


}
