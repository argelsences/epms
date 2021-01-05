<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Illuminate\Http\Request;
use App\Jobs\SendSubscribeConfirmationJob;
use EPPMS;
use Validator;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscriber $subscriber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscriber $subscriber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber)
    {
        //
    }
    /** 
     * API Function
     * Function to register a subscriber to receive updates from the department
     */
    public function subscribe(Request $request){

        $validate = Validator::make($request->all(), [
            'g-recaptcha-response' => 'required|captcha',
            'email' => 'required|email',
        ]);

        // search for the email of subscriber
        $subscriber = Subscriber::where([
                ['email' , $request->input('email')],
                ['department_id' , $request->input('department_id') ],
            ])->first();

        if ($subscriber){
            $success = false;
            $message = config('eppms.messages.existing_subscriber');
        }
        else {
            $newSubscriber = Subscriber::create([
                'email' => $request->input('email'),
                'token' => substr(str_replace('-','',EPPMS::generate_uuid()), 0, 32 ),
                'department_id' => $request->input('department_id'),
            ]);

            $details = [
                'department' => [
                    'name' => $newSubscriber->department->name,
                    'email' => $newSubscriber->department->email,
                ],
                'subscriber' => [
                    'email' => $newSubscriber->email,
                    'token' => $newSubscriber->token,
                ],
            ];

            SendSubscribeConfirmationJob::dispatch($details)
                ->delay(now()->addSeconds(5));
            
            
            $success = true;

            $message = config('eppms.messages.subscribe_message');
        }

        return ['success' => $success, 'message' => $message ];
    }

}
