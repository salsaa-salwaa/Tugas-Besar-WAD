<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diotorisasi untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return true; // Umumnya true jika diakses oleh pengguna yang terotentikasi
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk permintaan.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Sesuaikan aturan validasi ini agar sesuai dengan kolom tabel 'users' Anda
            // Contohnya, 'name' harus diganti dengan 'nama', dan 'email' tetap
            'nama' => ['string', 'max:255'], // Sesuaikan dengan kolom 'nama' di tabel users Anda
            'username' => ['string', 'max:255', Rule::unique(User::class)->ignore($this->user()->id_user, 'id_user')], // Sesuaikan dengan kolom 'username' dan primary key Anda
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id_user, 'id_user')], // Sesuaikan dengan primary key Anda
        ];
    }
}

