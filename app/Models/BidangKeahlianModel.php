<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangKeahlianModel extends Model
{
    use HasFactory;

    protected $table = 'm_bidang_keahlian';
    protected $primaryKey = 'id_bidang_keahlian';

    protected $fillable = [
        'bidang_keahlian_kode',
        'bidang_keahlian_nama',
    ];
}
