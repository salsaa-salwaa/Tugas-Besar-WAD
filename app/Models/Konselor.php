<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konselor extends Model
{
    use HasFactory;

    protected $table = 'konselors';

    protected $primaryKey = 'id_konselor';

    protected $fillable = [
        'nama',
        'no_telp',
        'keahlian',
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'konselor_id', 'id_konselor');
    }
}
