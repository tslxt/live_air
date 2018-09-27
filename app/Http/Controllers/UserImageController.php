<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Image;
use Validator;
use Illuminate\Support\Facades\Storage;
use Google\Cloud\Vision\VisionClient;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

class UserImageController extends Controller
{
    

    public function update(Request $request) {

    	$rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2560',
        ];

    	$validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


    	$path = $request->file('image')->store('images');

    	return response()->json(['path' => $path], 200);
    }

    public function bitmap(Request $request) {
    	$bitmap = base64_decode($request->bitmap);
    	$path = 'images/';
    	$path .= str_random(40);
    	$path .= '.png';
    	if (Storage::put($path, $bitmap)) {
    		return response()->json(['path' => $path], 200);
    	}else{
    		return response()->json('false', 400);
    	}
    	
    }

    public function vision(Request $request) {
    	$bitmap = base64_decode($request->bitmap);
    	
		$config = [
	        'credentials' => env('GOOGLE_CREDENTIALS'),
	    ];

	    $imageAnnotator = new ImageAnnotatorClient($config);

	    # annotate the image
	    $image = $bitmap;
	    $response = $imageAnnotator->textDetection($image);
	    $texts = $response->getTextAnnotations();

	    $content = '';

	    foreach ($texts as $text) {
	    	$content .= $text->getDescription();
	    }

		return response()->json(['text' => $content], 200);
    }

}
