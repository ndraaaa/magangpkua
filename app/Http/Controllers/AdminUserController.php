<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminUserController extends Controller
{
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('dashboard')->with('success', 'Admin baru berhasil ditambahkan!');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $admins = User::where('role', 'admin') // Syarat Wajib 1: Harus Admin
            ->when($search, function ($query, $search) {
                // Syarat Wajib 2: (Nama cocok ATAU Email cocok)
                // Kita bungkus dalam function($q) agar menjadi satu kesatuan
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        if ($request->ajax()) {
            return view('admin.users._table_body', compact('admins'))->render();
        }
        
        return view('admin.users.index', compact('admins'));
    }

    public function destroy($id)
    {
        if ($id == auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
        }

        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun Admin berhasil dihapus.');
    }
}