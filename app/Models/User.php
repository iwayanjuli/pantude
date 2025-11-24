<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser; // [WAJIB] Import interface ini
use Filament\Panel; // [WAJIB] Import class Panel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser // [WAJIB] Implementasikan interface
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Pastikan kolom 'role' ada di sini
        'avatar', // Jika Anda menambahkan fitur upload avatar nanti
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: User memiliki banyak Laporan
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    /**
     * [PENTING] Logika Akses Panel Admin Filament
     * Fungsi ini menentukan siapa yang boleh masuk ke /admin
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Jika id panel adalah 'admin', cek apakah role user adalah 'admin'
        if ($panel->getId() === 'admin') {
            return $this->role === 'admin';
        }

        // Default false (tidak boleh masuk)
        return false;
    }
}