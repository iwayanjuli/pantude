<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Tables;
use Filament\Tables\Table;

// --- IMPORT DARI NAMESPACE 'Filament\Actions' (SESUAI VERSI ANDA) ---
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

// Bulk Action biasanya tetap di Tables
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),

                TextColumn::make('email')
                    ->searchable()
                    ->icon('heroicon-m-envelope')
                    ->label('Email'),

                TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'user' => 'info',
                        default => 'gray',
                    })
                    ->sortable()
                    ->label('Role'),

                TextColumn::make('created_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->label('Terdaftar'),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'Administrator',
                        'user' => 'User Biasa',
                    ]),
            ])
            ->actions([
                // Menggunakan class dari Filament\Actions
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}