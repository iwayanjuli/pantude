<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pantude</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; line-height: 1.5; color: #333; }
        .container { width: 100%; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 24px; margin: 0; }
        .header p { font-size: 14px; margin: 5px 0; }
        .report-card { 
            border: 1px solid #ddd; 
            margin-bottom: 15px; 
            padding: 10px; 
            border-radius: 5px; 
            page-break-inside: avoid; /* Mencegah card terpotong antar halaman */
        }
        .report-card img { 
            max-width: 100%; 
            height: auto; 
            max-height: 200px; /* Batasi tinggi gambar */
            display: block; 
            margin: 0 auto 10px; 
            border-radius: 5px; 
        }
        .report-card h3 { font-size: 16px; margin: 0 0 10px; color: #000; }
        .report-card p { margin: 0 0 8px; }
        .report-card .label { font-weight: bold; }
        .report-card .status { 
            font-weight: bold; 
            padding: 3px 8px; 
            border-radius: 10px; 
            background-color: #eee; 
            display: inline-block; 
        }
        /* Logika warna status (opsional tapi bagus) */
        .status-diajukan { background-color: #e0e0e0; }
        .status-diterima { background-color: #fff8e1; color: #f57f17; }
        .status-ditolak { background-color: #ffebee; color: #d32f2f; }
        .status-selesai { background-color: #e8f5e9; color: #2e7d32; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Laporan PANTUDE</h1>
            <p>Export Laporan oleh: {{ Auth::user()->name }}</p>
            <p>Rentang Tanggal: 
                <strong>{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}</strong>
                s/d
                <strong>{{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</strong>
            </p>
        </div>

        <hr>

        @forelse ($reports as $report)
            <div class="report-card">
                <!-- 
                    PENTING: Mengubah gambar menjadi Base64 agar pasti tampil di PDF.
                    Ini adalah cara paling reliabel untuk dompdf.
                -->
                @php
                    try {
                        $imagePath = public_path('storage/' . $report->image_path);
                        if (file_exists($imagePath)) {
                            $imageData = base64_encode(file_get_contents($imagePath));
                            $imageSrc = 'data:' . mime_content_type($imagePath) . ';base64,' . $imageData;
                        } else {
                            $imageSrc = ''; // Path ke gambar placeholder jika ada
                        }
                    } catch (\Exception $e) {
                        $imageSrc = ''; // Gagal baca file
                    }
                @endphp
                
                @if ($imageSrc)
                    <img src="{{ $imageSrc }}" alt="{{ $report->title }}">
                @else
                    <div style="text-align: center; color: #888; border: 1px dashed #ccc; padding: 20px;">[Tidak ada gambar]</div>
                @endif

                <h3>{{ $report->title }}</h3>
                
                <p><span class="label">Tanggal:</span> {{ $report->incident_date->format('d M Y') }}</p>
                <p><span class="label">Lokasi:</span> {{ $report->location }}</p>
                <p><span class="label">Status:</span> 
                    <span class="status status-{{ $report->status }}">{{ ucfirst($report->status) }}</span>
                </p>
                <hr style="border: 0; border-top: 1px dashed #eee; margin: 10px 0;">
                <p><span class="label">Deskripsi:</span></p>
                <div style="white-space: pre-wrap;">{{ $report->description }}</div>
            </div>
        @empty
            <div style="text-align: center; font-size: 16px; color: #888;">
                <p>Tidak ada laporan yang ditemukan dalam rentang tanggal yang dipilih.</p>
            </div>
        @endforelse
    </div>
</body>
</html>