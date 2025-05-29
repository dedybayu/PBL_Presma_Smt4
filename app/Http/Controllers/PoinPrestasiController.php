<?php

namespace App\Http\Controllers;

use App\Models\PrestasiModel;
use Illuminate\Http\Request;

class PoinPrestasiController extends Controller
{
    public static function hitungPoin(PrestasiModel $prestasi)
    {
        $poin = 5;

        return $poin;
    }
}
