<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Lesson;
use App\Course;

class LessonsController extends Controller {

    public function index() {
    	return response()->json(Lesson::get(), 200);
    }

     public function show($id) {
    	$lesson = Lesson::find($id);
    	if (is_null($lesson)) {
    		return response()->json(null, 404);
    	}
    	return response()->json(Lesson::findorfail($id), 200);
    }

    public function store(Request $request) {
    	$lesson = Lesson::create($request->all());
    	return response()->json($lesson, 201);
    }

    public function update(Request $request, Lesson $lesson) {
        $lesson->update($request->all());
        return response()->json($lesson, 200);
    }
    public function delete(Request $request, Lesson $lesson) {
        $lesson->delete();
        return response()->json(null, 204);
    }
}
