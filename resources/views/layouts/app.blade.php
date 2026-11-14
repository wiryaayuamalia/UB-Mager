<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'UB Mager — Pasar Preloved Mahasiswa')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={theme:{extend:{colors:{maroon:'#650d2b',cream:'#f8f7f2',sun:'#fff4cc',wine:'#7d173b'}}}}</script>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
      :root{--wine:#650d2b;--wine2:#7d173b;--cream:#f8f7f2;--ink:#24232a;--muted:#777782;--line:#eceaf0;--gold:#f4d77c}
      *{box-sizing:border-box} body{font-family:'DM Sans',sans-serif;background:var(--cream);color:var(--ink)} h1,h2,h3,.brand{font-family:'Plus Jakarta Sans',sans-serif}
      nav.site-nav{background:rgba(255,255,255,.96);border-bottom:1px solid #eee;box-shadow:0 3px 16px #26132308}
      .page-shell{max-width:1240px;margin:auto;width:100%;padding:28px 24px 52px}
      .brand-mark{width:40px;height:40px;display:grid;place-items:center;background:var(--wine);color:#fff;border-radius:13px;font-weight:800;font-size:20px;box-shadow:0 5px 14px #650d2b24}
      .site-nav a{transition:.18s}.site-nav a:hover{color:var(--wine)}
      input,select,textarea{font:inherit} input:not([type=checkbox]):not([type=radio]),select,textarea{border:1px solid #e4e1e7;border-radius:11px;background:#fff;padding:11px 13px;outline:none;max-width:100%} input:focus,select:focus,textarea:focus{border-color:#a75b78!important;box-shadow:0 0 0 3px #650d2b12}
      button,.btn{transition:transform .15s,box-shadow .15s;cursor:pointer} button:hover,.btn:hover{transform:translateY(-1px);box-shadow:0 5px 14px #25102012}
      .bg-maroon{background:var(--wine)!important}.text-maroon{color:var(--wine)!important}.bg-cream{background:var(--cream)!important}.bg-sun{background:#fff4cc!important}
      main{min-height:calc(100vh - 180px)} footer{background:#fff;border-top:1px solid var(--line)}
      .card-polish{background:#fff;border:1px solid var(--line);border-radius:18px;box-shadow:0 5px 22px #1c152008}
      .status-pill{display:inline-flex;align-items:center;border-radius:999px;padding:5px 10px;font-size:11px;font-weight:700;background:#f3edf0;color:var(--wine)}
      .table-polish{width:100%;border-collapse:collapse;font-size:13px}.table-polish th{background:#faf9fb;color:#77717a;font-weight:700;text-align:left;padding:14px}.table-polish td{padding:14px;border-top:1px solid var(--line)}
      @media(max-width:760px){.page-shell{padding:18px 14px 36px}.nav-links{gap:10px;flex-wrap:wrap}.nav-links a{font-size:12px}.site-search{display:none}}
    </style>
    @stack('head')
</head>
<body class="min-h-screen flex flex-col">
<nav class="site-nav sticky top-0 z-40">
  <div class="max-w-7xl mx-auto px-5 py-3 flex items-center gap-5">
    <a href="{{ route('katalog.index') }}" class="flex items-center gap-3 shrink-0 no-underline">
      <span class="brand-mark">M</span><span class="leading-tight"><b class="brand text-maroon text-[17px]">UB Mager</b><br><small class="text-[10px] tracking-wide text-gray-500">MALANG–BATU PRELOVED MARKET</small></span>
    </a>
    <form action="{{ route('katalog.index') }}" class="site-search flex-1 max-w-xl relative">
      <span class="absolute left-3 top-2.5 text-gray-400">⌕</span><input name="q" value="{{ request('q') }}" placeholder="Cari barang, buku, fashion, elektronik..." class="w-full !pl-9 !bg-gray-50 !border-transparent !rounded-full !py-2.5 text-sm">
    </form>
    <div class="nav-links ml-auto flex items-center gap-4 text-[13px] font-semibold">
      <a href="{{ route('katalog.index') }}">Jelajahi</a>
      @auth
        <a href="{{ route('keranjang.index') }}">Keranjang</a><a href="{{ route('pesanan.saya') }}">Pesanan</a>
        @if(auth()->user()->role==='penjual')<a href="{{ route('penjual.dashboard') }}">Lapak Saya</a><a href="{{ route('penjual.chat') }}">Chat</a>
        @elseif(auth()->user()->role==='admin')<a href="{{ route('admin.pengajuan.index') }}">Admin</a>
        @else<a href="{{ route('pengajuan.form') }}">Jadi Penjual</a>@endif
        <a href="{{ route('profil.edit') }}" class="rounded-full bg-[#f7edf1] text-maroon px-3 py-2">{{ auth()->user()->nama }}</a>
        <form method="POST" action="{{ route('logout') }}">@csrf<button class="text-gray-500 text-xs">Keluar</button></form>
      @else
        <a href="{{ route('login') }}">Masuk</a><a href="{{ route('register') }}" class="bg-maroon text-white rounded-full px-4 py-2">Daftar</a>
      @endauth
    </div>
  </div>
</nav>
<main class="page-shell flex-1">
  @if(session('ok'))<div class="mb-5 rounded-xl border border-green-200 bg-green-50 text-green-800 px-4 py-3 text-sm">✓ {{ session('ok') }}</div>@endif
  @if(session('info'))<div class="mb-5 rounded-xl border border-blue-200 bg-blue-50 text-blue-800 px-4 py-3 text-sm">{{ session('info') }}</div>@endif
  @if(session('error'))<div class="mb-5 rounded-xl border border-red-200 bg-red-50 text-red-800 px-4 py-3 text-sm">{{ session('error') }}</div>@endif
  @if($errors->any())<div class="mb-5 rounded-xl border border-red-200 bg-red-50 text-red-800 px-4 py-3 text-sm"><b>Periksa kembali data yang dimasukkan:</b><ul class="list-disc ml-5 mt-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
  @yield('content')
</main>
<footer><div class="max-w-7xl mx-auto px-5 py-7 flex flex-wrap justify-between gap-4 text-xs text-gray-500"><span>© {{ date('Y') }} <b class="text-maroon">UB Mager</b> · Malang–Batu Campus Thrift</span><span>Pasar preloved aman, hemat, dan berkelanjutan untuk mahasiswa.</span></div></footer>
@stack('scripts')
</body></html>
