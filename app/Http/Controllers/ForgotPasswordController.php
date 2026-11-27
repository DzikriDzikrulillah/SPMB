<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    // Menampilkan form lupa password
    public function showForgotPasswordForm()
    {
        return view('auth.forgot_password');
    }

    // Proses lupa password (tanpa verifikasi email/token)
    public function submitForgotPassword(Request $request)
    {
        // Validasi email harus terdaftar di database
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak terdaftar dalam sistem kami.',
        ]);

        // Redirect langsung ke halaman reset password dengan email sebagai parameter
        return redirect()->route('reset_password', ['email' => $request->email]);
    }

    // Menampilkan form ganti password
    public function showResetPasswordForm(Request $request)
    {
        return view('auth.reset_password', ['email' => $request->email]);
    }

    // Proses ganti password
    public function submitResetPassword(Request $request)
    {
        // Validasi password baru
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Cari user berdasarkan email dan update password baru
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login.');
    }
}
