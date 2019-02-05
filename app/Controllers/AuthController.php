<?php

namespace App\Controllers;


use Chibi\Auth\Auth;
use Chibi\Controller\Controller;
use Chibi\Request;
use Chibi\Validation\Rule;

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
        $validator = $this
            ->validate($request->except('csrf_token'))
            ->addRule(
                ( new Rule('username'))->required()
            )->addRule(
                ( new Rule('password'))->required()
            );

        if(!$validator->check()){
            flash('error', 'Fields are required');

            return redirect(route('auth.login'));
        }
        // Validate form
        if($id = Auth::against('users')->canLogin($request->username, $request->password))
        {
            Auth::loginWith($id);

            return redirect(route('home'), [
                'success' => 'logged Ssuccessfully'
            ]);
        }

        flash('error', 'Bad Credentials');

        return redirect(route('auth.login'));
    }

    /**
     * Logout the connected user
     *
     */
    public function logout()
    {
        Auth::logOut();

        flash('success', 'Logged out successfully');

        return redirect(route('home'));
    }
}