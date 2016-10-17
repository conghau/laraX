<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 9/13/2016
 * Time: 4:35 AM
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use igaster\laravelTheme\Facades\Theme as Theme;
use Illuminate\Http\Request;

class AuthController extends BaseAdminController {
    /*
       |--------------------------------------------------------------------------
       | Registration & Login Controller
       |--------------------------------------------------------------------------
       |
       | This controller handles the registration of new users, as well as the
       | authentication of existing users. By default, this controller uses
       | a simple trait to add these behaviors. Why don't you explore it?
       |
       */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $username, $loginPath, $redirectPath, $redirectToLoginPage;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $this->username = 'username';
        $this->loginPath = 'auth';
        $this->redirectTo = '/' . $this->adminPath . '/dashboard';
        $this->redirectPath = '/' . $this->adminPath . '/dashboard';
        $this->redirectToLoginPage = '/' . $this->adminPath . '/auth/login';
        //$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'username' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data) {
        return AdminUser::create([
            'username' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Show form admin login
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function getLogin() {
        return view('admin.auth.login');
    }

    /**
     * Handler request from login form
     *
     * @param \Request $request
     */
    function postLogin(Request $request) {
        return $this->login($request);
    }

    function login(Request $request) {
        $this->validateLogin($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
//            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        $credentials = $this->getCredentials($request);
        $credentials['status'] = 1;

        if (auth()->guard('admin')->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }


//        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
//            return $this->handleUserWasAuthenticated($request, $throttles);
//        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);

    }
}