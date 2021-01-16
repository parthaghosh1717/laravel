<?php

namespace App\Http\Controllers\Auth;

use Session;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Notifications\verifyRegistration;


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
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function userEmailCheck(Request $request)
    {

     $user = User::where('email', trim($request->email))->where('status', '!=', 'D')->first();
      if(@$user) {
          return response('false');
      } else {
          return response('true');
      }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function register(Request $request)
    { 
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'gender' =>'required',
            'address' => 'required',
            'utype' =>'required',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
  
        $user = User::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'address' => $request->address,
            'type' => $request->utype,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token'=>Str::random(40),
            'status' => 0, 
        ]);

         

        $user->notify(new verifyRegistration($user));

        Session::flash('success', 'A Confertion email has send to you please chech,and confirm your email !!!');
        return redirect('login');
    }
}
