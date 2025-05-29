<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangKeahlianModel extends Model
{
    use HasFactory;

    protected $table = 'm_bidang_keahlian';
    protected $primaryKey = 'bidang_keahlian_id';

    protected $fillable = [
        'bidang_keahlian_kode',
        'bidang_keahlian_nama',
        'kategori_bidang_keahlian_id',
    ];

    public function kategoriBidangKeahlian()
    {
        return $this->belongsTo(KategoriBidangKeahlianModel::class, 'kategori_bidang_keahlian_id', 'kategori_bidang_keahlian_id');
    }
}
