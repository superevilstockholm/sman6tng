<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Requests
use App\Http\Requests\Auth\UpdatePasswordRequest;

class ChangePasswordController extends Controller
{
    public function view(): View
    {
        return view('pages.auth.change-password');
    }

    public function attempt(UpdatePasswordRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        $user->update([
            'password' => $validated['new_password'],
        ]);

        return back()->with('success', 'Berhasil memperbarui password.');
    }
}
