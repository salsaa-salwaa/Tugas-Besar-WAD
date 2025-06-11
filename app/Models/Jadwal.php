<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwals';

    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'konselor_id', 'hari', 'waktu', 'waktu_selesai'
    ];

    public function konselor()
    {
        return $this->belongsTo(Konselor::class, 'konselor_id', 'id_konselor');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'jadwal_id', 'id_jadwal');
    }
}
