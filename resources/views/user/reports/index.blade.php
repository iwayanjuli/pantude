<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Riwayat Laporan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Form Export PDF -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                    <h3 class="font-bold text-lg mb-2 text-gray-700">Export Laporan ke PDF</h3>
                    <form action="{{ route('user.reports.export') }}" method="GET" target="_blank">
                        <div class="flex flex-col md:flex-row md:items-end gap-4">
                            <div class="flex-1">
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                            </div>
                            <div class="flex-1">
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="end_date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                            </div>
                            <div class="flex-shrink-0">
                                <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm4 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0V9a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Export PDF
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Flash Message -->
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                     <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Tabel Laporan -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-bold uppercase border-r border-blue-500">Laporan</th>
                                <th class="px-6 py-3 text-left text-sm font-bold uppercase border-r border-blue-500">Lokasi</th>
                                <th class="px-6 py-3 text-left text-sm font-bold uppercase border-r border-blue-500">Tanggal</th>
                                <th class="px-6 py-3 text-center text-sm font-bold uppercase border-r border-blue-500">Status</th>
                                <th class="px-6 py-3 text-center text-sm font-bold uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-sky-50 divide-y divide-gray-200">
                            @forelse ($reports as $report)
                            <tr class="hover:bg-sky-100 transition">
                                <!-- Kolom Laporan -->
                                <td class="px-6 py-4 border-r border-gray-200">
                                    <div class="text-sm font-bold text-gray-900">{{ $report->title }}</div>
                                    <div class="text-xs text-gray-500">{{ Str::limit($report->description, 50) }}</div>
                                </td>
                                
                                <!-- Kolom Lokasi -->
                                <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 text-gray-800">
                                    {{ $report->location }}
                                </td>
                                
                                <!-- Kolom Tanggal -->
                                <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 text-gray-800">
                                    {{ $report->incident_date->format('d M Y') }}
                                </td>
                                
                                <!-- [FIX] Kolom Status dengan Badge Warna -->
                                <td class="px-6 py-4 whitespace-nowrap text-center border-r border-gray-200">
                                    @php
                                        $statusClasses = [
                                            'diajukan' => 'bg-gray-200 text-gray-800',
                                            'diterima' => 'bg-yellow-200 text-yellow-800',
                                            'ditolak'  => 'bg-red-200 text-red-800',
                                            'selesai'  => 'bg-green-200 text-green-800',
                                        ];
                                        $class = $statusClasses[$report->status] ?? 'bg-gray-200 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full uppercase {{ $class }}">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>

                                <!-- Kolom Aksi -->
                                <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                    <a href="{{ route('user.reports.show', $report->id) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-3 rounded shadow">
                                        Lihat
                                    </a>
                                    @if ($report->status == 'diajukan')
                                        <a href="{{ route('user.reports.edit', $report->id) }}" class="inline-block bg-yellow-500 hover:bg-yellow-700 text-white text-xs font-bold py-1 px-3 rounded shadow">
                                            Edit
                                        </a>
                                        <form action="{{ route('user.reports.destroy', $report->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-1 px-3 rounded shadow">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-500 bg-white">
                                    Belum ada laporan yang Anda buat.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-4">
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>