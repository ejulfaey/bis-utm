<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function login_post(LoginRequest $request)
    {
        $auth = auth()->attempt($request->only(['email', 'password']), $request->has('remember'));
        $event = 'succeed';
        $log = 'User has been logged in';

        if (!$auth) {
            $event = 'failed';
            $log = 'User fail to login';
        }

        activity()
            ->event($event)
            ->withProperties($request->only(['email', 'remember']))
            ->log($log);

        return $auth ? redirect()->to('/admin') : back()->withErrors('email', 'Failed to login!');
    }
}
