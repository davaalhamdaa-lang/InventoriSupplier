<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController
{
    public function index()
    {
        // Hanya ADMIN yang boleh mengakses halaman ini
        if (Auth::user()->role !== 'ADMIN') {
            return redirect('/dashboard')->withErrors(['akses' => 'Anda tidak memiliki hak akses ke Manajemen User.']);
        }

        $users = User::orderBy('created_at', 'desc')->get();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:150']);

        // Generate PIN 4 Digit Acak yang Unik (Tidak boleh ada yang sama di database)
        do {
            $pin = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (User::where('pin', $pin)->exists());

        User::create([
            'name' => $request->name,
            'pin' => $pin,
            'password' => null, // Operator tidak butuh password
            'role' => 'OPERATOR',
            'is_active' => true,
        ]);

        return back()->with('success', 'Akun Operator berhasil dibuat. PIN Akses: ' . $pin);
    }

    // Fungsi untuk mematikan/menghidupkan akun (Toggle)
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        
        // Mencegah admin menonaktifkan dirinya sendiri
        if ($user->id === Auth::id()) {
            return back()->withErrors(['akses' => 'Anda tidak bisa menonaktifkan akun Anda sendiri.']);
        }

        $user->is_active = !$user->is_active; // Balikkan nilai (true jadi false, dst)
        $user->save();

        return back();
    }
}