<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama',
        'username',
        'password',
        'role',
        'email',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'mahasiswa_id', 'id_user');
    }
}
