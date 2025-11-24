<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // GRID LAYOUT: 2 Kolom Utama (Konsisten dengan ReportForm)
                
                // KOLOM KIRI (Lebar 2/3): Informasi Utama User
                \Filament\Schemas\Components\FusedGroup::make()
                    ->schema([
                        \Filament\Schemas\Components\Section::make('Informasi Akun')
                            ->description('Informasi dasar pengguna.')
                            ->icon('heroicon-m-user')
                            ->schema([
                                // Nama
                                \Filament\Forms\Components\TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->required()
                                    ->maxLength(255),

                                // Email
                                \Filament\Forms\Components\TextInput::make('email')
                                    ->label('Alamat Email')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                            ])->columns(2), // Nama & Email sebelahan
                    ])->columnSpan(['lg' => 2]),

                // KOLOM KANAN (Lebar 1/3): Keamanan & Role
                \Filament\Schemas\Components\FusedGroup::make()
                    ->schema([
                        \Filament\Schemas\Components\Section::make('Akses & Keamanan')
                            ->description('Atur peran dan password pengguna.')
                            ->icon('heroicon-m-lock-closed')
                            ->schema([
                                // Role
                                \Filament\Forms\Components\Select::make('role')
                                    ->label('Peran / Role')
                                    ->options([
                                        'admin' => 'Administrator',
                                        'user'  => 'User Biasa',
                                    ])
                                    ->required()
                                    ->native(false),

                                // Password
                                \Filament\Forms\Components\TextInput::make('password')
                                    ->label('Password')
                                    ->password()
                                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->required(fn (string $context): bool => $context === 'create')
                                    ->helperText(fn (string $context): string => $context === 'edit' ? 'Kosongkan jika tidak ingin mengganti password.' : ''),
                                    
                                // Info Tambahan (Read Only)
                                \Filament\Forms\Components\Placeholder::make('created_at')
                                    ->label('Terdaftar Pada')
                                    ->content(fn ($record) => $record?->created_at?->diffForHumans() ?? '-')
                                    ->visibleOn('edit'),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }
}