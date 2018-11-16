<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LivesController extends Controller
{
    public function show($channel_id)
    {
    	$data = [];
    	$data['channel_id'] = $channel_id;
    	return view('live/show', $data);
    }
}
