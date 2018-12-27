<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

    //override trait
    protected function sendResetLinkResponse(Request $request, $response) {
        if($request->wantsJson())
            return response()->json(['status' => trans($response)]);
        return back()->with('status', trans($response));
    }

    //override trait
    protected function sendResetLinkFailedResponse(Request $request, $response) {
        if($request->wantsJson())
            return response()->json(['status' => trans($response)]);

        return back()->withErrors(
            ['email' => trans($response)]
        );
    }
}
