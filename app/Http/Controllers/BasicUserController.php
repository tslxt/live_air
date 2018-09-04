<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BasicUser;
use Validator;

class BasicUserController extends Controller
{
    //
    public function index() 
    {
		return response()->json(BasicUser::get(), 200);
	}

	public function show($id)
	{
		return response()->json(BasicUser::find($id), 200);
	}

	public function store(Request $request)
	{
		$rules = [
			'phone' => 'required|regex:/(1)[0-9]{10}/|unique:basic_users'
		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}
		$basicUser = BasicUser::create($request->all());
		return response()->json($basicUser, 201);
	}

	public function update(Request $request, BasicUser $basicUser)
	{
		$rules = [
			'phone' => 'required|regex:/(1)[0-9]{10}/|unique:basic_users'
		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}

		$basicUser->update($request->all());
		return response()->json($basicUser, 200);
	}

	public function delete(Request $request, BasicUser $basicUser)
	{
		$basicUser->delete();
		return response()->json(null, 204);
	}
}
