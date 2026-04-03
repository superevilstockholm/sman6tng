<?php

namespace App\Http\Controllers\Auth;


use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Requests
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function view(): View
    {
        return view('pages.auth.login', [
            'meta' => [
                'showNavbar' => false,
                'showFooter' => false,
            ]
        ]);
    }

    public function attempt(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Email atau password salah.')->withInput($request->except(['password']));
        }
        $request->session()->regenerate();
        return redirect()->route('dashboard.' . $request->user()->role->value . '.index')->with('success', 'Berhasil masuk.');
    }
}
