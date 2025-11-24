<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PANTUDE') }} - Pantau Hutan Desa</title>

    <linkpreconnect="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png">

    <style>
        /* Override font default jika perlu agar lebih mirip desain */
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="antialiased bg-gray-50">

    <nav class="bg-white py-4 px-6 md:px-12 flex justify-between items-center fixed w-full z-50 top-0 shadow-sm transition-all duration-300">
        <div class="flex items-center">
            <img src="{{ asset('img/logo.png') }}" alt="PANTUDE Logo" class="h-10 w-auto mr-3">
            <span class="text-2xl font-extrabold text-[#4ade80] tracking-wide">PANTUDE</span>
        </div>
        <div class="flex items-center gap-6 font-semibold text-[#4ade80]">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="hover:text-green-700 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-green-700 transition">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hover:text-green-700 transition">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <section class="relative min-h-screen flex items-center justify-center pt-20">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('img/landing-bg.jpg') }}" alt="Background Hutan" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/40"></div> </div>

        <div class="relative z-10 container mx-auto px-6 text-center text-white mt-10">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6 drop-shadow-lg">
                Selamat Datang Di Pantude
            </h1>
            
            <div class="inline-block bg-[#3bdc16] px-6 py-2 rounded-full mb-12 shadow-md">
                <p class="text-lg md:text-xl font-semibold">
                    Pantude merupakan platform digital untuk memudahkan :
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto text-gray-800">
                <div class="bg-white rounded-[30px] p-8 h-48 flex items-center justify-center shadow-[0_10px_40px_-15px_rgba(0,0,0,0.3)] hover:-translate-y-2 transition-transform duration-300">
                    <h3 class="text-2xl font-bold leading-tight">Monitoring<br>Hutan</h3>
                </div>
                <div class="bg-white rounded-[30px] p-8 h-48 flex items-center justify-center shadow-[0_10px_40px_-15px_rgba(0,0,0,0.3)] hover:-translate-y-2 transition-transform duration-300">
                    <h3 class="text-2xl font-bold leading-tight">Pelaporan<br>Hutan</h3>
                </div>
                <div class="bg-white rounded-[30px] p-8 h-48 flex items-center justify-center shadow-[0_10px_40px_-15px_rgba(0,0,0,0.3)] hover:-translate-y-2 transition-transform duration-300">
                    <h3 class="text-2xl font-bold leading-tight">Menjaga<br>Kelestarian Hutan</h3>
                </div>
            </div>
        </div>
    </section>

    <section id="berita" class="py-20 bg-gradient-to-b from-[#3bdc16] to-[#2eb810]">
        <div class="container mx-auto px-6 text-center">
            <div class="inline-block bg-[#27960f] px-8 py-3 rounded-full mb-12 shadow-inner">
                 <h2 class="text-white text-xl md:text-2xl font-bold">
                    Berita tentang Hutan Hari ini!
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                @if(isset($news) && count($news) > 0)
                    @foreach($news as $item)
                        <div class="bg-white rounded-[30px] overflow-hidden shadow-xl flex flex-col h-full hover:shadow-2xl transition-shadow duration-300">
                            <div class="h-48 overflow-hidden bg-gray-200">
                                @if($item->image_path)
                                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6 flex-grow flex flex-col text-left">
                                <div class="flex-grow">
                                    <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">{{ $item->title }}</h3>
                                    <p class="text-gray-600 text-sm line-clamp-3">
                                        {{ Str::limit($item->description, 100) }}
                                    </p>
                                </div>
                                <div class="mt-4 flex justify-between items-center text-sm">
                                    <span class="text-[#2eb810] font-semibold bg-green-50 px-3 py-1 rounded-full">
                                        {{ \Carbon\Carbon::parse($item->incident_date)->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    @for ($i = 1; $i <= 3; $i++)
                    <div class="bg-white rounded-[30px] p-6 h-72 flex items-center justify-center shadow-xl">
                        <h3 class="text-2xl font-bold text-gray-400">Berita {{ $i }}<br><span class="text-sm font-normal">(Belum tersedia)</span></h3>
                    </div>
                    @endfor
                @endif
            </div>
        </div>
    </section>