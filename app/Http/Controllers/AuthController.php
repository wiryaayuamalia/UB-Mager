<?php

namespace App\Http\Controllers;

use App\Models\{Pengguna, Otp};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Log, Mail};

class AuthController extends Controller
{
    public function showRegister() { return view('auth.register'); }

    // PGN-UR-01: registrasi dengan email / no HP + password
    public function register(Request $r)
    {
        $r->validate([
            'nama'     => 'required|string|max:100',
            'kontak'   => 'required|string|max:100',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $kontak = trim($r->kontak);
        $isEmail = str_contains($kontak, '@');

        if ($isEmail) {
            $r->validate(['kontak' => 'email|unique:pengguna,email']);
        } else {
            $r->validate(['kontak' => ['regex:/^[0-9+]{9,15}$/', 'unique:pengguna,no_hp']]);
        }

        $user = Pengguna::create([
            'nama' => $r->nama,
            'email' => $isEmail ? $kontak : null,
            'no_hp' => $isEmail ? null : $kontak,
            'password_hash' => Hash::make($r->password),
        ]);

        $this->kirimOtp($user);
        session(['otp_user' => $user->id_pengguna]);
        return redirect()->route('otp.form')->with('info', 'Kode OTP telah dikirim.');
    }

    private function kirimOtp(Pengguna $user): void
    {
        Otp::where('id_pengguna', $user->id_pengguna)->where('status', 'aktif')->update(['status' => 'kadaluarsa']);

        $kode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        Otp::create([
            'id_pengguna' => $user->id_pengguna,
            'kode_otp' => $kode,
            'waktu_kirim' => now(),
            'waktu_kadaluarsa' => now()->addMinutes(5),   // NFR-17: berlaku 5 menit
            'jumlah_percobaan' => 0,
            'status' => 'aktif',
        ]);

        if ($user->email) {
            Mail::raw("Kode OTP UB Mager Anda: $kode (berlaku 5 menit)", fn($m) => $m->to($user->email)->subject('Kode OTP UB Mager'));
        } else {
            // Integrasi SMS gateway (mis. Twilio/Zenziva) taruh di sini.
            Log::info("SMS OTP ke {$user->no_hp}: $kode");
        }
        Log::info("[DEV] OTP user {$user->id_pengguna}: $kode");
    }

    public function showOtp()
    {
        abort_unless(session('otp_user'), 404);
        return view('auth.otp');
    }

    // PGN-UR-02: verifikasi OTP
    public function verifyOtp(Request $r)
    {
        $r->validate(['kode' => 'required|digits:6']);
        $user = Pengguna::findOrFail(session('otp_user'));
        $otp = Otp::where('id_pengguna', $user->id_pengguna)->where('status', 'aktif')->latest('id_otp')->first();

        if (!$otp || now()->gt($otp->waktu_kadaluarsa)) {
            $otp?->update(['status' => 'kadaluarsa']);
            return back()->withErrors(['kode' => 'OTP kadaluarsa. Silakan kirim ulang.']);
        }

        if ($otp->kode_otp !== $r->kode) {
            $otp->increment('jumlah_percobaan');
            if ($otp->jumlah_percobaan >= 3) {
                $otp->update(['status' => 'kadaluarsa']);
                return back()->withErrors(['kode' => 'Percobaan habis (3x). Silakan kirim ulang OTP.']);
            }
            return back()->withErrors(['kode' => 'OTP salah. Sisa percobaan: ' . (3 - $otp->jumlah_percobaan)]);
        }

        $otp->update(['status' => 'terpakai']);
        $user->update(['status_verifikasi' => 'terverifikasi']);
        session()->forget('otp_user');
        Auth::login($user);
        return redirect()->route('profil.edit')->with('ok', 'Akun terverifikasi. Lengkapi profil Anda.');
    }

    public function resendOtp()
    {
        $user = Pengguna::findOrFail(session('otp_user'));
        $this->kirimOtp($user);
        return back()->with('info', 'OTP baru telah dikirim.');
    }

    public function showLogin() { return view('auth.login'); }

    public function login(Request $r)
    {
        $r->validate(['kontak' => 'required', 'password' => 'required']);
        $user = Pengguna::where('email', $r->kontak)->orWhere('no_hp', $r->kontak)->first();

        if (!$user || !Hash::check($r->password, $user->password_hash)) {
            return back()->withErrors(['kontak' => 'Email/No HP atau password salah.'])->withInput();
        }
        if ($user->status_akun !== 'aktif') {
            return back()->withErrors(['kontak' => 'Akun tidak aktif / disuspend.']);
        }
        if ($user->status_verifikasi !== 'terverifikasi') {
            $this->kirimOtp($user);
            session(['otp_user' => $user->id_pengguna]);
            return redirect()->route('otp.form')->with('info', 'Verifikasi akun dulu dengan OTP.');
        }

        Auth::login($user);
        $r->session()->regenerate();
        return redirect()->intended($user->role === 'admin' ? route('admin.pengajuan.index') : route('katalog.index'));
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('katalog.index');
    }
}
