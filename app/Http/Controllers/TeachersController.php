<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teacher;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Enums\UserType;

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

        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();
        
        return response()->json($teacher, 200);
    }

    public function register()
    {
        $user = Auth::user();
        $teacher = $user->isTeacher;

        if($teacher == null || $teacher == '') {
            $teacher = new Teacher();
            $user->role = UserType::Teacher;
            $user->save();
            $teacher->user_id = $user->id;
            $teacher->save();
        }
                
        return response()->json($teacher, 200);
    }

}
