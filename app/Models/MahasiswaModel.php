<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class MahasiswaModel extends Model
{
    use HasFactory;
    protected $table = 'm_mahasiswa';
    protected $primaryKey = 'mahasiswa_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'tahun_angkatan',
        'nim',
        // 'password',
        'nama',
        'kelas_id',
        'no_tlp',
        'email',
        'alamat',
        'foto_profile',
    ];

    // protected $hidden = ['password'];
    // protected $casts = ['password' => 'hashed'];

    // Relasi ke kelas
    public function kelas()
    {
        return $this->belongsTo(KelasModel::class, 'kelas_id', 'kelas_id');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

}
