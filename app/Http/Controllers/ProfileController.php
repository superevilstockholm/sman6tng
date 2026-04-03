<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

// Requests
use App\Http\Requests\Profile\UpdateRequest;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user()->load(['profile']);
        return view('pages.dashboard.profile.index', [
            'user' => $user,
        ]);
    }

    public function edit(Request $request): View
    {
        $user = $request->user()->load(['profile']);
        return view('pages.dashboard.profile.edit', [
            'user' => $user,
        ]);
    }

    public function update(UpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        if ($request->boolean('delete_profile_picture')) {
            if ($user->profile_picture_path && Storage::disk('public')->exists($user->profile_picture_path)) {
                Storage::disk('public')->delete($user->profile_picture_path);
            }
        }

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture_path && Storage::disk('public')->exists($user->profile_picture_path)) {
                Storage::disk('public')->delete($user->profile_picture_path);
            }
            $validated['profile_picture_path'] = $request->file('profile_picture')->store('account/profile-pictures', 'public');
        }

        unset($validated['profile_picture'], $validated['delete_profile_picture']);

        DB::transaction(function () use ($validated, $user) {
            $user->update($validated);
            $user->profile()->updateOrCreate([], $validated);
        });

        return back()->with('success', 'Berhasil memperbarui profil.');
    }
}
