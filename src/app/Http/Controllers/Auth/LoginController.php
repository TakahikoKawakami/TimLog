<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request) //: JsonResponse
    {
        $guard = $this->authManager->guard('api');
        $token = $guard->attempt([
            'email' =>  $request->get('email'),
            'password'  =>  $request->get('password'),
        ]);
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // return redirect('/')->header('Authorization:Bearer', $token)->with('token', $token);
        return new JsonResponse($token);
    }

    public function redirectPath()
    {
        $test = 'test;';
        return '/home';
        //例）return 'costs/index';
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        // ここから
        if (array_key_exists('HTTP_REFERER', $_SERVER)) {
            $path = parse_url($_SERVER['HTTP_REFERER']); // URLを分解
            if (array_key_exists('HOST', $path)) {
                if ($path['HOST'] == $_SERVER['HTTP_HOST']) { // ホスト部分が自ホストと同じ
                    session(['url.intended' => $_SERVER['HTTP_REFERER']]);
                }
            }
        }
        // ここまで追加
        return view('auth.login');
    }
}
