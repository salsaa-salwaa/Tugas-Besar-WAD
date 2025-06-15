<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // Ini tidak diperlukan jika Anda tidak menggunakan verifikasi email
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthenticatableBase; // Mengubah alias agar tidak bertabrakan dengan nama interface
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable; // Mengimpor interface Authenticatable

// Pastikan model User Anda extends AuthenticatableBase (yang adalah Illuminate\Foundation\Auth\User)
// DAN secara eksplisit mengimplementasikan interface Authenticatable.
class User extends AuthenticatableBase implements Authenticatable
{
    use HasFactory, Notifiable;

    // Definisikan primary key jika bukan 'id'
    protected $primaryKey = 'id_user';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'role',
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Dapatkan atribut yang harus di-cast.
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
}

