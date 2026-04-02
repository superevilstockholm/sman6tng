<?php

namespace App\Http\Controllers\Account;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\Account\User;

// Requests
use App\Http\Requests\Account\User\IndexRequest;
use App\Http\Requests\Account\User\StoreRequest;

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
            $user->profile()->create([
                'name' => $validated['name'],
            ]);
        });

        return redirect()->route('dashboard.admin.account.users.index')->with('success', 'Berhasil menambahkan user.');
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
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
