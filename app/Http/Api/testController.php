<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class testController extends Controller
{
    public function demo()
    {
    	return [
    		"name" => "taw",
    		"age" => 33,
    		"habbit" => "ping pong"
    	];
    }	
}
