<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use Session;
use Cookie;
use App\User;


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
    //protected $redirectTo = '/propertytype';
    protected $redirectTo ;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
   
   
    public function authenticated(Request $request,$user)
    {
       $remember = $request->get('remember');
       
        $auth = Auth::attempt(
            [
                'email'  => strtolower($request->get('email')),
                'password'  => $request->get('password')    
            ], $remember
        );
        if($auth){
            if(isset($remember)){
                $ckname = Auth::getRecallerName();
                Cookie::queue($ckname, Cookie::get($ckname), 43200);
                Cookie::queue('remembered','remembered', 43200);
                Cookie::queue('email',$request->get('email'), 43200);
                Cookie::queue('pass',$request->get('password'), 43200);
            }else{
                $ckname = Auth::getRecallerName();
                Cookie::queue($ckname, '', 43200);
                Cookie::queue('remembered','', 43200);
                Cookie::queue('email','', 43200);
                Cookie::queue('pass','', 43200);
            }
            $this->setUserSession($user);
            if(Auth::user()->role == 1){
                $this->redirectTo = '/propertytype';
            }
            if(Auth::user()->role == 2){
                $this->redirectTo = route('home');
            }
            if((Auth::user()->role == 2) && ($request->session()->get('property_id'))){
                $propertyId = $request->session()->get('property_id');
                Session::forget('key');
                $this->redirectTo = 'property-detail?property_id='.$propertyId;
            }
        } else {
            return Redirect::to('/')
                ->withInput(Input::except('password'))
                ->with('flash_notice', 'Your username/password combination was incorrect.');
        }
 
    }




    /*=============================
        Check is email is Verified
    ================================*/
    protected function credentials(Request $request) {
        $credentials = $request->only($this->username(), 'password');
        $credentials['is_verified'] = 1;
        return $credentials;
    }

     /*==============================================
       Change Error Message if Email is not Verified
    ===================================================*/
    protected function sendFailedLoginResponse(Request $request) {
        $errors = [$this->username() => trans('auth.failed')];
        // Load user from database
        $user = \App\User::where($this->username(), $request->{$this->username()})->first();
        if ($user && \Hash::check($request->password, $user->password) && $user->is_verified != 1) {
            $errors = [$this->username() => 'Please verify your email before login.'];
        }
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    protected function setUserSession($user) {
        Session::put('user_session',  $user->email);
    }
}
