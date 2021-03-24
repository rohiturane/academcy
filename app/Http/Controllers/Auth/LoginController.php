<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Devices;
use App\Models\User;

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
    //protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(Auth::check() && Auth::user()->role == 1){
            $this->redirectTo = route('home');
        } elseif(Auth::check() && Auth::user()->role == 2){
            $this->redirectTo = route('student.dashboard');
        }
        $this->middleware('guest')->except('logout');
    }
    /*protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'exists:users,' . $this->username() . ',active,1',
            'password' => 'required|string',
        ], [
            $this->username() . '.exists' => 'The selected email is invalid or the account has been disabled.'
        ]);
    }*/
    public function authenticate(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember');
        if (Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1],$remember)) {
            // Authentication passed...
            
            //return redirect()->intended('home');
        }
    }
    public function login(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if( $user && !$user->active){
            session()->flash('error','Your Account has been deactivated. Please contact to admin if you have any query.');
            return redirect()->back();
        }

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $deviceexist = Devices::where('user_agent','like',$_SERVER['HTTP_USER_AGENT'])->where('ip_address',$_SERVER['REMOTE_ADDR'])->where('user_id',Auth::id())->first();
            if(empty($deviceexist)) {
                $device = Devices::create([
                    'user_id'=>Auth::user()->id,
                    'user_agent'=>$_SERVER['HTTP_USER_AGENT'],
                    'ip_address'=>$_SERVER['REMOTE_ADDR']
                ]);
            }
            //var_dump(Auth::user()); exit;
            if(Auth::user()->role == 1) {
                return redirect('/home');
            } else{
                return redirect('/student/dashboard');
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}
