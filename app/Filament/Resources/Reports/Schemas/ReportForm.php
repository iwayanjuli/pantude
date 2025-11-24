<?php

namespace App\Filament\Resources\Reports\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString; // [PENTING] Import ini untuk render HTML gambar

class ReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // GRID LAYOUT: 2 Kolom Utama
                
                // KOLOM KIRI (Lebar 2/3): Detail Laporan (Read Only)
                \Filament\Schemas\Components\FusedGroup::make()
                    ->schema([
                        \Filament\Schemas\Components\Section::make('Detail Laporan User')
                            ->description('Informasi yang dikirimkan oleh pelapor.')
                            ->schema([
                                // Pelapor
                                \Filament\Forms\Components\Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->label('Pelapor')
                                    ->disabled()
                                    ->dehydrated(false),

                                // Judul
                                \Filament\Forms\Components\TextInput::make('title')
                                    ->label('Judul Laporan')
                                    ->disabled(),

                                // Tanggal Kejadian
                                \Filament\Forms\Components\DatePicker::make('incident_date')
                                    ->label('Tanggal Kejadian')
                                    ->disabled(),

                                // Lokasi
                                \Filament\Forms\Components\TextInput::make('location')
                                    ->label('Lokasi')
                                    ->disabled(),

                                // Deskripsi
                                \Filament\Forms\Components\Textarea::make('description')
                                    ->label('Deskripsi Lengkap')
                                    ->rows(4)
                                    ->columnSpanFull()
                                    ->disabled(),
                            ])->columns(2),

                        // [PERBAIKAN] Bagian Bukti Foto - Menggunakan Tampilan Gambar Langsung
                        \Filament\Schemas\Components\Section::make('Bukti Foto')
                            ->description('Foto asli yang diunggah pelapor.')
                            ->schema([
                                // Kita gunakan Placeholder untuk merender tag HTML <img> secara langsung
                                // Ini menjamin gambar pasti muncul jika filenya ada.
                                \Filament\Forms\Components\Placeholder::make('tampilan_gambar')
                                    ->label('') // Label kosong agar lebih bersih
                                    ->content(function ($record) {
                                        if ($record && $record->image_path) {
                                            // Generate URL gambar
                                            $imageUrl = asset('storage/' . $record->image_path);
                                            
                                            // Render HTML Image
                                            return new HtmlString('
                                                <div style="display: flex; justify-content: center; background-color: #f3f4f6; padding: 10px; border-radius: 8px;">
                                                    <a href="' . $imageUrl . '" target="_blank" title="Klik untuk memperbesar">
                                                        <img src="' . $imageUrl . '" 
                                                             alt="Bukti Laporan" 
                                                             style="max-width: 100%; max-height: 500px; border-radius: 8px; object-fit: contain; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);" />
                                                    </a>
                                                </div>
                                                <div style="text-align: center; margin-top: 5px; font-size: 0.8em; color: #666;">
                                                    (Klik gambar untuk membuka di tab baru)
                                                </div>
                                            ');
                                        }
                                        return new HtmlString('<div style="color: red; font-style: italic;">Tidak ada bukti foto yang dilampirkan.</div>');
                                    })
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpan(['lg' => 2]),

                // KOLOM KANAN (Lebar 1/3): Panel Validasi Admin
                \Filament\Schemas\Components\FusedGroup::make()
                    ->schema([
                        \Filament\Schemas\Components\Section::make('Validasi Laporan')
                            ->description('Ubah status untuk memproses laporan ini.')
                            ->icon('heroicon-m-check-badge')
                            ->schema([
                                // Status
                                \Filament\Forms\Components\Select::make('status')
                                    ->label('Status Laporan')
                                    ->options([
                                        'diajukan' => 'Diajukan (Baru)',
                                        'diterima' => 'Diterima (Proses)',
                                        'ditolak'  => 'Ditolak',
                                        'selesai'  => 'Selesai',
                                    ])
                                    ->default('diajukan')
                                    ->required()
                                    ->native(false)
                                    ->selectablePlaceholder(false),
                                    
                                // Info tambahan
                                \Filament\Forms\Components\Placeholder::make('created_at')
                                    ->label('Dibuat Pada')
                                    ->content(fn ($record) => $record?->created_at?->diffForHumans() ?? '-'),

                                \Filament\Forms\Components\Placeholder::make('updated_at')
                                    ->label('Terakhir Diupdate')
                                    ->content(fn ($record) => $record?->updated_at?->diffForHumans() ?? '-'),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }
}