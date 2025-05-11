<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class AdminModel extends Authenticatable
{
    use HasFactory;
    protected $table = 'm_admin';
    protected $primaryKey = 'admin_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'username',
        'password',
        'nama',
        'email',
        'no_tlp',
        'foto_profile',
    ];

    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];
}
