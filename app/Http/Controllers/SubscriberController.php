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
            'g_recaptcha_response' => 'required|captcha',
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

    /**
     * Unsubscribe a user if one opt-out
     * @params token => unique token assigned to a subscriber
     */
    public function unsubscribe(Request $request){
        $token = null;

        if ($request->exists('token')) {
            $token = $request->query('token');
            $subscriber = Subscriber::where('token', $token)->first();
            
            if ($subscriber){
                return view('front.subscriber.homepage', compact('subscriber'));
            }
            else {
                abort(404);
            }
        }
        else {
            abort(404);
        }
        
    }

    /**
     * API function to unsubscribe subscriber
     */
    public function unsubscribed(Request $request){
        $validate = Validator::make($request->all(), [
            'g_recaptcha_response' => 'required|captcha',
            'token' => 'required',
        ]);

        $token = $request->input('s_token');

        $subscriber = Subscriber::where('token', $token)->delete();

        return ['success' => true, 'message' => 'You are now unsubscribe, we will redirect this page shortly' ];
    }

}
