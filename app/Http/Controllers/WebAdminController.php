<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebAdminController extends Controller
{
    //
    public function dashboard(){
        return view('admin.dashboard');
    }
}
