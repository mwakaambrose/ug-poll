<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\includes\notifications\config;
use App\includes\notifications\Firebase;
use App\includes\notifications\Push;

class NotificationController extends Controller
{
    //
    public function index(){
    	return view('notifications.index');
    }
    //
    
}
