<?php

namespace App\Filament\Resources\Users;

// Pastikan semua 'use' Pages ada di sini
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\ViewUser; // Tambahkan ini
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    // Ganti ikon agar lebih sesuai
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'name';
    
    protected static ?string $navigationLabel = 'Manajemen User';

    public static function form(Schema $schema): Schema
    {
        // Memanggil file Form terpisah
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        // Memanggil file Tabel terpisah
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'), // Tambahkan ini
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}