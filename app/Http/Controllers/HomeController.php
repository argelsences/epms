<?php

namespace App\Http\Controllers;
use App\Department;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /////$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        //return view('dashboard');
        return view('welcome');
    }

    public function department( $URI ){
        $theURI = filter_var($URI, FILTER_SANITIZE_STRING);
        $department = Department::where('url', $URI)->firstOrFail();
        //dd($department);
        /////return view('');
    }
}
