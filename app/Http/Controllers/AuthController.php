<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // 1. Validasi input awal (PIN wajib 4 digit)
        $request->validate([
            'pin' => 'required|digits:4',
        ]);

        // 2. Cari user berdasarkan PIN
        $user = User::where('pin', $request->pin)->first();

        // 3. Jika PIN tidak ditemukan di database
        if (!$user) {
            return back()->withErrors(['pin' => 'PIN tidak ditemukan atau salah.']);
        }

        // 4. Jika akun dinonaktifkan
        if (!$user->is_active) {
            return back()->withErrors(['pin' => 'Akun Anda dinonaktifkan oleh Admin.']);
        }

        // 5. Jika yang login adalah ADMIN, wajib cek password
        if ($user->role === 'ADMIN') {
            if (!$request->password) {
                return back()->withErrors(['password' => 'Admin wajib memasukkan Password.']);
            }
            if (!Hash::check($request->password, $user->password)) {
                return back()->withErrors(['password' => 'Password Admin salah.']);
            }
        }

        // 6. Eksekusi Login (Berlaku untuk Operator dan Admin yang lolos cek)
        Auth::login($user);

        // 7. Catat Histori Aktivitas (Audit Log)
        DB::table('tb_audit_logs')->insert([
            'user_id' => $user->id,
            'action' => 'LOGIN',
            'table_name' => 'tb_users',
            'record_id' => $user->id,
            'created_at' => now(),
        ]);

        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}