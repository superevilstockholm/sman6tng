<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

// Requests
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    public function login_view(): View
    {
        return view('pages.auth.login', [
            'meta' => [
                'showNavbar' => false,
                'showFooter' => false,
            ]
        ]);
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Email atau password salah.')->withInput($request->except(['password']));
        }
        $request->session()->regenerate();
        return redirect()->route('dashboard.' . $request->user()->role->value . '.index')->with('success', 'Berhasil masuk.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil keluar.');
    }
}
