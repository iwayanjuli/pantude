<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Laporan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex items-center mb-6">
                    <a href="{{ route('user.reports.index') }}" class="mr-4 text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800 uppercase">Edit Laporan Kejadian</h1>
                </div>

                <!-- Form Edit -->
                <form action="{{ route('user.reports.update', $report->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH') <!-- Method untuk Update -->

                    <!-- Tampilkan Gambar Saat Ini -->
                    <div class="flex flex-col items-center">
                        <label class="font-bold">Gambar Saat Ini:</label>
                        <img src="{{ asset('storage/' . $report->image_path) }}" alt="Bukti Laporan" class="w-full md:w-2/3 max-h-60 object-cover rounded-lg shadow-md mb-4">
                    </div>

                    <!-- Upload Gambar Baru (Opsional) -->
                    <div class="flex justify-center">
                        <label for="image" class="w-full md:w-2/3 h-32 flex flex-col items-center justify-center bg-gray-200 rounded-lg border-2 border-dashed border-gray-400 cursor-pointer hover:bg-gray-300 transition">
                            <span class="mt-2 text-base leading-normal text-gray-600 font-semibold">Ganti Gambar (Opsional)</span>
                            <input type='file' name="image" id="image" class="hidden" accept="image/*"/>
                        </label>
                    </div>
                    @error('image') <p class="text-red-500 text-sm text-center">{{ $message }}</p> @enderror

                    <div class="bg-gray-100 p-6 rounded-lg space-y-4 border">
                        <!-- Judul Laporan -->
                        <div>
                            <label class="font-bold ml-2">Judul Laporan</label>
                            <input type="text" name="title" class="w-full rounded-full border-gray-400 px-4 py-2" required value="{{ old('title', $report->title) }}">
                            @error('title') <p class="text-red-500 text-sm ml-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="font-bold ml-2">Deskripsi</label>
                            <textarea name="description" rows="3" class="w-full rounded-2xl border-gray-400 px-4 py-2" required>{{ old('description', $report->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-sm ml-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Tanggal Kejadian -->
                        <div>
                            <label class="font-bold ml-2">Tanggal Kejadian</label>
                            <input type="date" name="incident_date" class="w-full rounded-full border-gray-400 px-4 py-2" required value="{{ old('incident_date', $report->incident_date->format('Y-m-d')) }}">
                             @error('incident_date') <p class="text-red-500 text-sm ml-2">{{ $message }}</p> @enderror
                        </div>

                         <!-- Lokasi -->
                        <div>
                            <label class="font-bold ml-2">Lokasi</label>
                            <input type="text" name="location" class="w-full rounded-full border-gray-400 px-4 py-2" required value="{{ old('location', $report->location) }}">
                             @error('location') <p class="text-red-500 text-sm ml-2">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-12 rounded-full shadow-lg text-lg">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>