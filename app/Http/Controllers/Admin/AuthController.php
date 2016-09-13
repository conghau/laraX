<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 9/13/2016
 * Time: 4:35 AM
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use igaster\laravelTheme\Facades\Theme as Theme;


class AuthController extends Controller {
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

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
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
            'name' => 'required|max:255',
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Show form admin login
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function showFormLogin() {
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
    }

    function validateLogin(Request $request) {

    }
}