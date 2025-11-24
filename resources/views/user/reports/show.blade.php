<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Detail Laporan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex items-center mb-6">
                    <a href="{{ route('user.reports.index') }}" class="mr-4 text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800 uppercase">Detail Laporan Kejadian</h1>
                </div>

                <!-- Status Laporan -->
                <div class="mb-4 text-center">
                    <span class="px-4 py-2 text-lg font-semibold rounded-full 
                        {{ $report->status === 'selesai' ? 'bg-green-100 text-green-800' : 
                          ($report->status === 'ditolak' ? 'bg-red-100 text-red-800' : 
                          ($report->status === 'diterima' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                        Status: {{ ucfirst($report->status) }}
                    </span>
                </div>

                <!-- Tampilkan Gambar -->
                <div class="flex flex-col items-center">
                    <img src="{{ asset('storage/' . $report->image_path) }}" alt="Bukti Laporan" class="w-full md:w-2/3 max-h-72 object-cover rounded-lg shadow-md mb-4">
                </div>

                <!-- Info Read-Only -->
                <div class="bg-gray-100 p-6 rounded-lg space-y-4 border">
                    <div>
                        <label class="font-bold text-gray-500">Judul Laporan</label>
                        <p class="text-lg text-gray-900">{{ $report->title }}</p>
                    </div>
                    <hr>
                    <div>
                        <label class="font-bold text-gray-500">Deskripsi</label>
                        <p class="text-lg text-gray-900 whitespace-pre-wrap">{{ $report->description }}</p>
                    </div>
                    <hr>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="font-bold text-gray-500">Tanggal Kejadian</label>
                            <p class="text-lg text-gray-900">{{ $report->incident_date->format('d F Y') }}</p>
                        </div>
                        <div>
                            <label class="font-bold text-gray-500">Lokasi</label>
                            <p class="text-lg text-gray-900">{{ $report->location }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Tombol Aksi (Jika status 'diajukan') -->
                @if ($report->status == 'diajukan')
                <div class="flex justify-end mt-6 space-x-4">
                    <a href="{{ route('user.reports.edit', $report->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-6 rounded-full shadow-lg text-lg">
                        Edit
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>