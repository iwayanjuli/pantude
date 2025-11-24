<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-green-600">Dashboard Laporan Kamu</h1>
            </div>

            <div class="flex justify-center mb-12">
                <a href="{{ route('user.reports.create') }}" class="flex items-center bg-[#3bdc16] hover:bg-green-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transition duration-300 transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Laporkan kejadian
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 px-4">
                <div class="text-center">
                    <div class="bg-blue-500 text-white font-bold text-xl py-4 rounded-t-xl shadow-md">Dikirim</div>
                    <div class="bg-blue-600 text-white font-extrabold text-4xl py-8 rounded-b-xl shadow-md">{{ $stats['diajukan'] }}</div>
                </div>
                <div class="text-center">
                    <div class="bg-yellow-400 text-white font-bold text-xl py-4 rounded-t-xl shadow-md">Diterima</div>
                    <div class="bg-yellow-500 text-white font-extrabold text-4xl py-8 rounded-b-xl shadow-md">{{ $stats['diterima'] }}</div>
                </div>
                <div class="text-center">
                    <div class="bg-red-500 text-white font-bold text-xl py-4 rounded-t-xl shadow-md">Ditolak</div>
                    <div class="bg-red-600 text-white font-extrabold text-4xl py-8 rounded-b-xl shadow-md">{{ $stats['ditolak'] }}</div>
                </div>
                <div class="text-center">
                    <div class="bg-[#3bdc16] text-white font-bold text-xl py-4 rounded-t-xl shadow-md">Selesai</div>
                    <div class="bg-[#33bf13] text-white font-extrabold text-4xl py-8 rounded-b-xl shadow-md">{{ $stats['selesai'] }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>