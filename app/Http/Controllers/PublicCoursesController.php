<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Public_course;
use Validator;

class PublicCoursesController extends Controller
{
	 public function index() 
    {
    	return response()->json(Public_course::get(), 200);
    }

    public function show($id)
    {
    	$public_course = Public_course::find($id);
    	if (is_null($public_course)) {
    		return response()->json(null, 404);
    	}
    	return response()->json(Public_course::findorfail($id), 200);
    }

    public function store(Request $request)
    {
    	$rules = [
    		'title' => 'required|max:80',
    	];
    	$validator = Validator::make($request->all(), $rules);
    	if ($validator->fails()) {
    		return response()->json($validator->errors(), 400);
    	}
    	$public_course = Public_course::create($request->all());
    	return response()->json($public_course, 201);
    }

    public function update(Request $request, Public_course $public_course)
    {
    	$public_course->update($request->all());
    	return response()->json($public_course, 200);
    }
}
