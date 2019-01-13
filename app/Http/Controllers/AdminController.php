<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //

    public function __construct()
    {
    	// define middlleware
    }

    public function  dashboard()
    {
    	return  view('admin.dashboard');
    }
}
