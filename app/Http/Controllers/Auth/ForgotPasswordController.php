<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
/*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getForgot()
    {
        return view('dashboard.auth.forgot');
    }

    public function postForgot(Request $request)
    {
        $response = $this->broker()->sendResetLink($request->only('email'), function (Message $message){
            $message->subject("Reset Password");
        });

        switch($response)
        {
            case Password::RESET_LINK_SENT:
                return view('dashboard.auth.forgot-sent');
            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['login'=>'Email tidak valid']);
        }
    }
}
