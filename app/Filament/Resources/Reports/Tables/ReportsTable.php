<?php

namespace App\Filament\Resources\Reports\Tables;

use App\Models\Report;
use Filament\Tables;
use Filament\Tables\Table;

// --- IMPORT DARI NAMESPACE 'Filament\Actions' (KONSISTEN) ---
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
// Gunakan Bulk Action dari Filament\Actions juga jika tersedia, 
// TAPI: Filament v3/v4 standar memisahkan Bulk Action di Tables.
// Jika error berlanjut, kita gunakan FQCN (Fully Qualified Class Name) untuk aman.

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;

class ReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Bukti')
                    ->circular(),

                TextColumn::make('title')
                    ->label('Judul Laporan')
                    ->searchable()
                    ->limit(30)
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Pelapor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('location')
                    ->label('Lokasi')
                    ->limit(20),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'diajukan' => 'gray',
                        'diterima' => 'warning',
                        'ditolak'  => 'danger',
                        'selesai'  => 'success',
                    })
                    ->sortable(),

                TextColumn::make('incident_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'diajukan' => 'Diajukan',
                        'diterima' => 'Diterima',
                        'ditolak'  => 'Ditolak',
                        'selesai'  => 'Selesai',
                    ]),
            ])
            ->actions([
                // Menggunakan class dari Filament\Actions
                ViewAction::make(),
                EditAction::make()->label('Validasi'),
                DeleteAction::make(),
            ])
            ->bulkActions([
                // GUNAKAN PATH LENGKAP (FQCN) AGAR AMAN DARI KONFLIK IMPORT
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}