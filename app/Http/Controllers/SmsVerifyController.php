<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SmsManager;
use Validator;

class SmsVerifyController extends Controller
{
    public function verify(Request $request)
    {
    	$validator = Validator::make($request->all(), [
		    'mobile'     => 'required|confirm_mobile_not_change|confirm_rule:mobile_required',
		    'verifyCode' => 'required|verify_code',
		]);
		if ($validator->fails()) {
		   SmsManager::forgetState();
		   return response()->json($validator->errors(), 400);
		}

		return response()->json($validator, 200);

    }
}
