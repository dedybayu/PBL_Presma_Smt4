<?php

namespace App\Http\Controllers;

use App\Models\LombaModel;
use Illuminate\Http\Request;

class RekomendasiMahasiswaController extends Controller
{
    public function rekomendasiByTopsis(LombaModel $lomba){
        $bidang = $lomba->bidang;
    }
}
