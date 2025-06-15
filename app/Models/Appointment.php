<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $primaryKey = 'id_appointment';

    protected $fillable = [
        'mahasiswa_id',
        'jadwal_id',
        'tanggal',
        'deskripsi',
        'tipe',
        'status',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id', 'id_user');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id', 'id_jadwal');
    }
}
