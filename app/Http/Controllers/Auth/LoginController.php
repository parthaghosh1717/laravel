<?php

namespace App\Http\Controllers\Auth;

use Session;
use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Notifications\verifyRegistration;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showUserLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // dd($request->all());

        $this->validate($request,[
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        //Find user by this email...
        $username = $request->email;
        $userpass = $request->password;
        $chk = $request->checkbox;

        $user = User::where('email',$request->email)->first();

        // dd($user);
        if (!is_null($user)) 
        {
            if (@$user->status == 1) 
            {
     
                //Login this user.....

                if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password],$request->remember)) 
                {
                     //Login now..
                     // dd('login now');
                    if(@$user->type == 'S')
                    {
                        // dd('student');
                        Session::put("userses",$username);
                        Session::put("passuser",$userpass);
                        Session::put("rem",$chk);
                        return redirect()->intended(route('student.dashboard'));

                    }
                    elseif(@$user->type == 'T')
                    {
                        // dd('teacher');
                        return redirect()->intended(route('teacher.dashboard'));
                    }
                    // return redirect()->intended(route('home'));
                }

                else
                {
                
                    return redirect()->back()->with('error', 'These credentials do not match our records.');

                }

            }
            else
            {
                //Send a new responced...

                if (!is_null($user)) 
                {

                    $user->notify(new verifyRegistration($user));

                    // Session::flash('success', 'You are not verified your email, A New Confertion email has send to you please check,and confirm your email !!!');
                    return redirect('login')->with('success','You are not verified your email, A new confirmation email has send to you please check,and confirm your email !!!');
                } 

            }

        }
        else
        {
            // Session::flash('success', 'We have found no recoard please register !');
            return redirect()->route('login')->with('error','We have found no recoard if you are not register, please register !!!');
        }



        





        // $this->guard()->logout();
    }
}
