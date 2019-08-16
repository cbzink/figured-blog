<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Shows the login page.
     *
     * @return Illuminate\View\View
     */
    public function login()
    {
        return view('login');
    }
    
    /**
     * Processes an author's login request.
     *
     * @param  App\Http\Requests\LoginRequest $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function handleLogin(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return redirect()->back()->withErrors(['email' => 'The email or password you provided is incorrect.']);
        }

        return redirect('/');
    }

    /**
     * Processes an author's logout request.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function handleLogout()
    {
        Auth::logout();

        return redirect('/');
    }
}
