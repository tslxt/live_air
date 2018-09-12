<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Course;
use APP\Lesson;

class CoursesController extends Controller
{
    public function index() 
    {
    	return response()->json(Course::get(), 200);
    }

    public function show($id)
    {
    	$course = Course::find($id);
    	if (is_null($course)) {
    		return response()->json(null, 404);
    	}
    	return response()->json(Course::findorfail($id), 200);
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
    	$course = Course::create($request->all());
    	return response()->json($course, 201);
    	// return response()->json($request, 200);
    }

    public function update(Request $request, Course $course)
    {
    	$course->update($request->all());
    	return response()->json($course, 200);
    }

    public function delete(Request $request, Course $course)
    {
    	$course->delete();
    	return response()->json(null, 204);
    }

    public function lessons(Request $request, Course $course)
    {
        $lessons = $course->hasManyLessons;
        return response()->json($lessons, 200);
    }
}
