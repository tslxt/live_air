<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teacher;
use Illuminate\Support\Facades\Auth;
use Validator;

class TeachersController extends Controller
{
    public function store(Request $request)
    {
    	$user = Auth::user(); 

    	$rules = [
            'name' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($request-> all(), 400);
        }

        $teacher = new Teacher();
        $teacher->name = $request->input('name');
        $teacher->user_id = $user->id;

        $teacher->save();
        return response()->json($teacher, 200);
    }

    public function show(Request $request)
    {
        $user = Auth::user(); 
        $teacher = new Teacher();
        $teacher->name = $request->input('name');
        $teacher->user_id = $user->id;
        $teacher->save();
        return response()->json($teacher, 201);
    }

}
