<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 17/10/2016
 * Time: 12:01
 */

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api
 */
class AuthController extends BaseApiController {
  /**
   * Api logging
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(Request $request) {
    $input = $request->all();
    try {
      if (!$token = JWTAuth::attempt($input)) {
        return response()->json([
          'result' => FALSE,
          'token' => 'invalid_credentials'
        ]);
      }
    }
    catch (JWTException $e) {
      return response()->json([
        'result' => FALSE,
        'token' => 'could_not_create_token'
      ]);
    }

    return response()->json(['result' => TRUE, 'token' => $token]);
  }

//  public function signup(Request $request) {
//    $signupFields = Config::get('boilerplate.signup_fields');
//    $hasToReleaseToken = Config::get('boilerplate.signup_token_release');
//
//    $userData = $request->only($signupFields);
//
//    $validator = Validator::make($userData, Config::get('boilerplate.signup_fields_rules'));
//
//    if ($validator->fails()) {
//      throw new ValidationHttpException($validator->errors()->all());
//    }
//
//    User::unguard();
//    $user = User::create($userData);
//    User::reguard();
//
//    if (!$user->id) {
//      return $this->response->error('could_not_create_user', 500);
//    }
//
//    if ($hasToReleaseToken) {
//      return $this->login($request);
//    }
//
//    return $this->response->created();
//  }

  public function get_user_details(Request $request) {
    $input = $request->all();
    $user = JWTAuth::toUser($input['token']);
    return response()->json(['result' => $user]);
  }
}