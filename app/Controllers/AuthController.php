<?php

namespace App\Controllers;


use Chibi\Auth\Auth;
use Chibi\Controller\Controller;
use Chibi\Request;

class AuthController extends Controller
{

    /**
     * Login page
     *
     * @throws \Chibi\Exceptions\ViewNotFoundException
     */
    public function login()
    {
        return view('auth.login');
    }


    /**
     * Perform login
     *
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function postLogin(Request $request)
    {
        // Validate form

        if($id = Auth::against('users')->canLogin($request->username, $request->password))
        {
            //Auth::loginWith($id);

            return redirect(route('home'));
        }
        return redirect(route('auth.login'),[
            'error' => 'Not found'
        ]);
    }
}