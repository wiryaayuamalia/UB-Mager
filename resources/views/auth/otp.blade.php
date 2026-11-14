
@extends('layouts.app')

@section('title', 'Verifikasi OTP')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 py-10 bg-[#faf9f4]">
    <div class="w-full max-w-[520px] bg-white rounded-2xl shadow-lg p-7 sm:p-8">

        {{-- Logo --}}
        <div class="flex items-center gap-3 mb-8">
            <div class="w-11 h-11 rounded-lg bg-[#801d43] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor"
                     stroke-width="1.8">
                    <rect x="5" y="10" width="14" height="11" rx="2"/>
                    <path stroke-linecap="round" d="M8 10V7a4 4 0 018 0v3"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-[#351523]">UB MAGER</h2>
                <p class="text-[10px] font-bold tracking-wide text-[#75636a]">
                    PRELOVED MAHASISWA MALANG – BATU
                </p>
            </div>
        </div>

        {{-- Stepper --}}
        <div class="grid grid-cols-2 gap-2 p-1.5 rounded-lg bg-[#f4f2ed] mb-8">

            {{-- Langkah 1: Selesai --}}
            <div class="flex items-center justify-center gap-2 rounded-md py-2.5 text-sm font-bold text-[#801d43]">
                <span class="w-5 h-5 rounded-full bg-[#801d43] text-white flex items-center justify-center text-xs">
                    ✓
                </span>
                Registrasi Akun
            </div>

            {{-- Langkah 2: Aktif --}}
            <div class="flex items-center justify-center gap-2 bg-white rounded-md py-2.5 text-sm font-bold text-[#801d43] shadow-sm">
                <span class="w-5 h-5 rounded-full bg-[#801d43] text-white flex items-center justify-center text-xs">
                    2
                </span>
                Verifikasi OTP
            </div>

        </div>

        {{-- Heading --}}
        <div class="text-center mb-7">
            <div class="w-16 h-16 rounded-full bg-[#f8edf1] flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#801d43]"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor"
                     stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>

            <h1 class="text-2xl font-extrabold text-[#351523] mb-2">
                Verifikasi Akun
            </h1>
            <p class="text-sm text-[#75636a] leading-relaxed">
                Masukkan 6 digit kode OTP yang telah dikirimkan ke email
                atau nomor HP yang kamu daftarkan.
            </p>
        </div>

        {{-- Informasi --}}
        <div class="bg-[#faf6dc] border border-[#f1e9b8] rounded-xl p-4 mb-6 flex gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#801d43] shrink-0 mt-0.5"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                 stroke-width="1.8">
                <circle cx="12" cy="12" r="9"/>
                <path stroke-linecap="round" d="M12 11v5m0-8h.01"/>
            </svg>
            <div>
                <p class="text-sm font-bold text-[#651735]">Periksa pesan masuk kamu</p>
                <p class="text-xs text-[#5f5053] leading-relaxed mt-1">
                    Kode OTP berlaku selama 5 menit. Jangan bagikan kode ini
                    kepada siapa pun.
                </p>
            </div>
        </div>

        {{-- Pesan --}}
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 p-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Form OTP --}}
        <form method="POST" action="{{ route('otp.verify') }}" id="otpForm">
            @csrf

            <label class="block text-sm font-bold text-[#351523] mb-3 text-center">
                Masukkan Kode OTP
            </label>

            <div class="flex justify-center gap-2 sm:gap-3 mb-3">
                @for($i = 0; $i < 6; $i++)
                    <input
                        type="text"
                        inputmode="numeric"
                        maxlength="1"
                        autocomplete="one-time-code"
                        class="otp-digit w-11 h-14 sm:w-14 sm:h-16 border border-[#e5dfe2] rounded-xl text-center text-2xl font-bold text-[#801d43] focus:border-[#801d43] focus:ring-2 focus:ring-[#801d43]/20 outline-none transition"
                        aria-label="Digit OTP {{ $i + 1 }}"
                    >
                @endfor
            </div>

            <input type="hidden" name="kode" id="kode">

            <p class="text-xs text-center text-[#8a777e] mb-6">
                Masukkan kode yang terdiri dari 6 angka.
            </p>

            <button
                type="submit"
                class="w-full bg-[#801d43] hover:bg-[#681735] text-white rounded-lg py-3.5 font-bold shadow-md transition">
                Verifikasi Sekarang →
            </button>
        </form>

        {{-- Kirim ulang --}}
        <div class="text-center mt-6">
            <p class="text-sm text-[#75636a] mb-2">
                Belum menerima kode OTP?
            </p>

            <form method="POST" action="{{ route('otp.resend') }}">
                @csrf
                <button type="submit"
                    class="text-sm font-bold text-[#801d43] hover:underline">
                    Kirim Ulang OTP
                </button>
            </form>
        </div>

        <div class="border-t border-[#eee8eb] mt-7 pt-5 text-center">
            <p class="text-xs text-[#9a8b90]">
                UB Mager · Preloved Mahasiswa Malang – Batu
            </p>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    const otpInputs = document.querySelectorAll('.otp-digit');
    const otpHidden = document.getElementById('kode');
    const otpForm = document.getElementById('otpForm');

    function updateOtpValue() {
        otpHidden.value = Array.from(otpInputs)
            .map(input => input.value)
            .join('');
    }

    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 1);

            if (this.value && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }

            updateOtpValue();
        });

        input.addEventListener('keydown', function (event) {
            if (event.key === 'Backspace' && !this.value && index > 0) {
                otpInputs[index - 1].focus();
            }

            if (event.key === 'ArrowLeft' && index > 0) {
                otpInputs[index - 1].focus();
            }

            if (event.key === 'ArrowRight' && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        });

        input.addEventListener('paste', function (event) {
            event.preventDefault();

            const pasted = event.clipboardData
                .getData('text')
                .replace(/\D/g, '')
                .slice(0, 6);

            pasted.split('').forEach((digit, i) => {
                if (otpInputs[i]) otpInputs[i].value = digit;
            });

            updateOtpValue();

            const nextEmpty = Array.from(otpInputs)
                .find(input => !input.value);

            (nextEmpty || otpInputs[5]).focus();
        });
    });

    otpForm.addEventListener('submit', function (event) {
        updateOtpValue();

        if (otpHidden.value.length !== 6) {
            event.preventDefault();
            alert('Masukkan 6 digit kode OTP terlebih dahulu.');
            const firstEmpty = Array.from(otpInputs)
                .find(input => !input.value);
            if (firstEmpty) firstEmpty.focus();
        }
    });

    otpInputs[0].focus();
</script>
@endpush
