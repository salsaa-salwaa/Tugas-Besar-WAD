<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feedback';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mahasiswa_id', 
        'konselor_id', 
        'rating', 
        'komentar'
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model User (Mahasiswa).
     */
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id', 'id_user');
    }

    /**
     * Mendefinisikan relasi "belongsTo" ke model Konselor.
     * NAMA FUNGSI INI DIUBAH DARI 'admin' MENJADI 'konselor'
     */
    public function konselor()
    {
        return $this->belongsTo(Konselor::class, 'konselor_id', 'id_konselor');
    }
}
