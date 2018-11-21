<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LivesController extends Controller
{
    public function show($channel_id)
    {
    	$data = [];
    	$data['channel_id'] = $channel_id;
    	return view('live/play', $data);
    }

    public function test()
    {
    	return view('live.test');
    }
}

