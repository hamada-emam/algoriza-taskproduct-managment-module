<?php

namespace App\Traits\Auth;

use App\Enums\RoleCode;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

trait AuthenticatesUsers
{
    /**
     * Attempt to log the user in.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin($request)
    {
        // Use the Auth facade to attempt to log in the user
        return Auth::attempt($request->only('email', 'password'), $request->filled('remember'));
    }

    /**
     * Send the login response after a successful login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLoginResponse($request)
    {
        $request->session()->regenerate();

        return auth()->user()->role->code === RoleCode::ADMIN ? redirect()->intended('dashboard') : redirect('/');
    }

    /**
     * Send the failed login response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse($request)
    {
        return back()->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => trans('auth.failed')]);
    }
}
