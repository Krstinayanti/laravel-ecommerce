<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    
    public function index() {

    	$user = User::find(Auth::user()->id);

    	return view('notification', [
    		'user' => $user
    	]);

   	}

}
