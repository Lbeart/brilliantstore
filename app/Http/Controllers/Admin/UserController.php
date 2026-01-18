<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
   
   
   // App\Http\Controllers\Admin\UserController.php

public function index(Request $request)
{
    $search  = trim($request->query('search', ''));
    $role    = $request->query('role');
    $sort    = $request->query('sort', 'newest');
    $perPage = (int) $request->query('per_page', 15);

    $users = \App\Models\User::query()
        ->when($search !== '', function ($q) use ($search) {
            $q->where(function ($qq) use ($search) {
                $qq->where('name','like',"%{$search}%")
                   ->orWhere('email','like',"%{$search}%");
            });
        })
        ->when($role, fn($q) => $q->where('role', $role))
        ->when($sort, function ($q) use ($sort) {
            return match ($sort) {
                'oldest'  => $q->orderBy('created_at','asc'),
                'name_az' => $q->orderBy('name','asc'),
                'name_za' => $q->orderBy('name','desc'),
                default   => $q->orderBy('created_at','desc'), // newest
            };
        })
        ->paginate($perPage)
        ->withQueryString();

    return view('admin.users.index', compact('users','search','role','sort','perPage'));
}

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Vetëm nëse password është mbushur, ndryshohet
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Përdoruesi u përditësua me sukses.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'Përdoruesi u fshi me sukses.');
    }
}
