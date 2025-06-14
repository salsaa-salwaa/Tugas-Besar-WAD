<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['mahasiswa_id', 'konselor_id', 'rating', 'komentar'];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id', 'id_user');
    }

    public function konselor()
    {
        return $this->belongsTo(Konselor::class, 'konselor_id', 'id_konselor');
    }

}
