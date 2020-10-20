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
    
        /// script
        /** @var Organiser $organiser */
        /*$organiser = Organiser::findOrFail($organiser_id);

        if (!$organiser->enable_organiser_page && !Utils::userOwns($organiser)) {
            abort(404);
        }*/

        /*
         * If we are previewing styles from the backend we set them here.
         */
        /*
        if ($request->get('preview_styles') && Auth::check()) {
            $query_string = rawurldecode($request->get('preview_styles'));
            parse_str($query_string, $preview_styles);

            $organiser->page_bg_color = $preview_styles['page_bg_color'];
            $organiser->page_header_bg_color = $preview_styles['page_header_bg_color'];
            $organiser->page_text_color = $preview_styles['page_text_color'];
        }*/

        $upcoming_events = $department->events()->where([
            ['end_date', '>=', now()],
            ['is_public', 1]
        ])->get();

        $past_events = $department->events()->where([
            ['end_date', '<', now()],
            ['is_public', 1]
        ])->limit(10)->get();
        
        /*
        $data = [
            'department'       => $organiser,
            'tickets'         => $organiser->events()->orderBy('created_at', 'desc')->get(),
            'is_embedded'     => 0,
            'upcoming_events' => $upcoming_events,
            'past_events'     => $past_events,
        ];
        */
        
        /// end script
        
        return view('front.department.homepage', compact(
            'department',
            'upcoming_events',
            'past_events'
        ));
    }
    
}
