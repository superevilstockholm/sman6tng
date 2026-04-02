<?php

namespace App\Http\Controllers\Account;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\Account\User;

// Requests
use App\Http\Requests\Account\User\IndexRequest;
use App\Http\Requests\Account\User\StoreRequest;
use App\Http\Requests\Account\User\UpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): View
    {
        $validated = $request->validated();
        $limit = $validated['limit'] ?? 10;
        $query = User::query()->with(['profile']);

        if (!empty($validated['email'])) {
            $query->where('email', 'ILIKE', '%' . $validated['email'] . '%');
        }
        if (!empty($validated['role'])) {
            $query->where('role', $validated['role']);
        }
        if (!empty($validated['name'])) {
            $query->whereHas('profile', function ($q) use ($validated) {
                $q->where('name', 'ILIKE', '%' . $validated['name'] . '%');
            });
        }
        if (!empty($validated['phone'])) {
            $query->whereHas('profile', function ($q) use ($validated) {
                $q->where('phone', 'ILIKE', '%' . $validated['phone'] . '%');
            });
        }

        $users = $query->paginate($limit)
            ->appends($request->except('page'));

        return view('pages.dashboard.admin.account.user.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.dashboard.admin.account.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $user = User::create($validated);
            $user->profile()->create($validated);
        });

        return redirect()->route('dashboard.admin.account.users.index')->with('success', 'Berhasil membuat data pengguna.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('pages.dashboard.admin.account.user.show', [
            'user' => $user->load(['profile']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('pages.dashboard.admin.account.user.edit', [
            'user' => $user->load(['profile']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

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

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        DB::transaction(function () use ($validated, $user) {
            $user->update($validated);
            $user->profile()->updateOrCreate([], $validated);
        });

        return redirect()->route('dashboard.admin.account.users.index')->with('success', 'Berhasil mengubah data pengguna.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->profile_picture_path && Storage::disk('public')->exists($user->profile_picture_path)) {
            Storage::disk('public')->delete($user->profile_picture_path);
        }
        $user->delete();
        return redirect()->route('dashboard.admin.account.users.index')->with('success', 'Berhasil menghapus data pengguna.');
    }
}
