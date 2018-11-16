<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Public_course;
use App\Teacher;
use App\User;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PublicCoursesController extends Controller
{
	 public function index() 
    {
    	$user = Auth::user();
    	$teacher = $user->isTeacher;
    	$courses = $teacher->public_courses;
    	if ($courses) {
    		return response()->json($courses, 200);
    	}else {
    		return response()->json($courses, 400);
    	}
    	
    }

    public function show($id)
    {
    	$user = Auth::user();
    	$public_course = Public_course::find($id);
    	if (is_null($public_course)) {
    		return response()->json(null, 404);
    	}
    	return response()->json(Public_course::findorfail($id), 200);
    }

    public function store(Request $request)
    {
    	$user = Auth::user();

    	$rules = [
    		'title' => 'required|max:80',
    	];
    	$validator = Validator::make($request->all(), $rules);
    	if ($validator->fails()) {
    		return response()->json($validator->errors(), 400);
    	}
    	
    	
    	$teacher = $user->isTeacher;
    	
    	$public_course = new Public_course();
    	$public_course->teacher_id = $teacher->id;
    	$public_course->title = $request->input("title");

    	$public_course->save();
    	return response()->json($public_course, 201);
    }

    public function update(Request $request, Public_course $public_course)
    {
    	$user = Auth::user();
    	$public_course->update($request->all());
    	return response()->json($public_course, 200);
    }

    public function upload(Request $request, Public_course $public_course)
    {
    	$validator = Validator::make($request->all(), [
            'pdf' => 'required|file|max:2048',
        ]);
        if ($validator->fails()) {
           return response()->json($validator->errors(), 400);
        }
    	$path = $request->file('pdf')->store('pdfs', 'public');
    	$public_course->courseware = $path;
    	$public_course->save();
    	return response()->json($public_course, 200); 
    }


    public function delete(Request $request,Public_course $public_course)
    {
    	$user = Auth::user();
    	if ($public_course->courseware) {
    		Storage::delete('public/'.$public_course->courseware);
    	}
    	$public_course->delete();
    	return response()->json(null, 204);
    }



}
