<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/shift';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    //override true response function in AuthenticatesUsers trait
    protected function sendLoginResponse(Request $request) {

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if($request->wantsJson()) return response()->json(['status' => 'success', 'user'=>\Auth::user(), 'token' => csrf_token()]); //->with("region")->first()

        return redirect('/dashboard');
        //return $this->authenticated($request, $this->guard()->user()) ?: redirect()->intended($this->redirectPath());
    }

    //overrid false response function in AuthenticatesUsers trait
    protected function sendFailedLoginResponse(Request $request) {
        if($request->wantsJson())
            return response()->json(['status' => 'failed']);
          
        return $this->throwView($request, "Authentication error!");
        /*
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);*/
    }

    //override logout response function in AuthenticatesUsers trait
    public function logout(Request $request) {
        $this->guard()->logout();

        $request->session()->invalidate();

        if($request->wantsJson())
            return response()->json(['status' => 'logged out']);

        return redirect('/');
    }

    public function getToken(Request $request) {
        if($request->wantsJson()){
            return response()->json([
                'pass' => csrf_token()
            ]);
        }
        return '<b> Not for web interface. </b> '. ($request->isJson()? '(Set proper content type)': '(Content okay)');
    }

    function throwView($request, $message, $redirect='/'){
      if($request->wantsJson()) {
        return response()->json(["error"=> $message]);
      } else {
        Session::flash('FhkAuthorization', $message); 
        return redirect($redirect);
      }
    }
}
