<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Buat Laporan Baru') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center mb-6">
                    <a href="{{ route('dashboard') }}" class="mr-4 text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800 uppercase">Laporkan Kejadian</h1>
                </div>

                <form action="{{ route('user.reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="flex justify-center">
                        <label class="w-full md:w-2/3 h-48 flex flex-col items-center justify-center bg-gray-200 rounded-lg border-2 border-dashed border-gray-400 cursor-pointer hover:bg-gray-300 transition">
                            <span class="text-gray-600 font-semibold">Unggah Gambar Bukti</span>
                            <input type='file' name="image" class="hidden" required accept="image/*" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0]); document.getElementById('preview').classList.remove('hidden');"/>
                        </label>
                    </div>
                    <div class="flex justify-center"><img id="preview" class="hidden max-h-48 rounded-lg shadow-md" /></div>

                    <div class="bg-gray-100 p-6 rounded-lg space-y-4 border">
                        <div><label class="font-bold ml-2">Judul Laporan</label><input type="text" name="title" class="w-full rounded-full border-gray-400 px-4 py-2" required></div>
                        <div><label class="font-bold ml-2">Deskripsi</label><textarea name="description" rows="3" class="w-full rounded-2xl border-gray-400 px-4 py-2" required></textarea></div>
                        <div><label class="font-bold ml-2">Tanggal Kejadian</label><input type="date" name="incident_date" class="w-full rounded-full border-gray-400 px-4 py-2" required></div>
                        <div><label class="font-bold ml-2">Lokasi</label><input type="text" name="location" class="w-full rounded-full border-gray-400 px-4 py-2" required></div>
                    </div>
                    <div class="flex justify-end"><button type="submit" class="bg-[#3bdc16] hover:bg-green-700 text-white font-bold py-2 px-12 rounded-full shadow-lg">Kirim</button></div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>