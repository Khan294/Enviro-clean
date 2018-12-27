<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    /*
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }*/

    public function isValid($fields){
      return \Validator::make($fields, [
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',
      ])->fails()? false: true;
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => 'Customer',
            'contact' => '',
            'wage' => '-',
        ]);
    }

    //override trait
    public function register(Request $request)
    {
        //return response()->json(['status' => 'failed', 'message' => 'Registeration is not allowed.']);

        $data= $request->all();
        if(!$this->isValid($data))
            return response()->json(["error" => "Check your arguments."]);

        event(new Registered($user = $this->create($data)));

        $this->guard()->login($user);

        if($request->wantsJson())
            return response()->json(['status' => 'registered']);
        return redirect($this->redirectPath());

        //return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }
}
