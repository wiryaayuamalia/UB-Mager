<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UB Mager')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { maroon: '#6B1D3A', cream: '#F7F6EE', sun: '#F6F3CF' } } } }
    </script>
</head>
<body class="bg-cream text-gray-800 min-h-screen flex flex-col">
<nav class="bg-white/80 backdrop-blur border-b sticky top-0 z-10">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center gap-4">
        <a href="{{ route('katalog.index') }}" class="flex items-center gap-2">
            <span class="bg-maroon text-white font-bold rounded-lg px-2 py-1">M</span>
            <span class="leading-tight"><b class="text-maroon">UB Mager</b><br><small class="text-xs text-gray-500">Malang-Batu Thrift</small></span>
        </a>
        <form action="{{ route('katalog.index') }}" class="flex-1 hidden md:block">
            <input name="q" value="{{ request('q') }}" placeholder="Cari jaket, buku kuliah, kos gear di UB / Batu..."
                   class="w-full bg-gray-100 rounded-lg px-4 py-2 text-sm">
        </form>
        <a href="{{ route('katalog.index') }}" class="text-sm font-semibold">Katalog</a>
        @auth
            <a href="{{ route('pesanan.saya') }}" class="text-sm font-semibold">Pesanan Saya</a>
            <a href="{{ route('keranjang.index') }}" class="text-sm font-semibold">Keranjang</a>
            @if(auth()->user()->role === 'penjual')
                <a href="{{ route('penjual.dashboard') }}" class="text-sm font-semibold text-maroon">Dashboard Penjual</a>
            @elseif(auth()->user()->role === 'admin')
                <a href="{{ route('admin.pengajuan.index') }}" class="text-sm font-semibold text-maroon">Admin</a>
            @else
                <a href="{{ route('pengajuan.form') }}" class="text-sm font-semibold text-maroon">Jadi Penjual</a>
            @endif
            <a href="{{ route('profil.edit') }}" class="text-sm bg-maroon text-white rounded-full px-3 py-1">{{ auth()->user()->nama }}</a>
            <form method="POST" action="{{ route('logout') }}">@csrf <button class="text-sm text-gray-500">Keluar</button></form>
        @else
            <a href="{{ route('login') }}" class="text-sm font-semibold">Masuk</a>
            <a href="{{ route('register') }}" class="text-sm bg-maroon text-white rounded-lg px-3 py-1.5">Daftar</a>
        @endauth
    </div>
</nav>

<main class="max-w-6xl mx-auto w-full px-4 py-6 flex-1">
    @if(session('ok'))    <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-800">{{ session('ok') }}</div> @endif
    @if(session('info'))  <div class="mb-4 p-3 rounded-lg bg-blue-100 text-blue-800">{{ session('info') }}</div> @endif
    @if(session('error')) <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-800">{{ session('error') }}</div> @endif
    @if($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-800">
            <ul class="list-disc ml-5 text-sm">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif
    @yield('content')
</main>

<footer class="bg-white border-t mt-8">
    <div class="max-w-6xl mx-auto px-4 py-6 text-xs text-gray-500">© {{ date('Y') }} UB Mager (Malang-Batu Campus Thrift). Dibuat untuk Mahasiswa Malang Raya.</div>
</footer>
</body>
</html>
