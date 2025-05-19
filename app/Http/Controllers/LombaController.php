<?php

namespace App\Http\Controllers;

use App\Models\BidangKeahlianModel;
use App\Models\LombaModel;
use App\Models\PenyelenggaraModel;
use App\Models\TingkatLombaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LombaController extends Controller
{
    public function index(LombaModel $lomba){
        $tingkat = TingkatLombaModel::all();
        $bidang = BidangKeahlianModel::all();
        $penyelenggara = PenyelenggaraModel::all();
        return view('admin.lomba.daftar_lomba')->with(['lomba' => $lomba, 'tingkat' => $tingkat, 'bidang' => $bidang, 'penyelenggara' => $penyelenggara]);
    }

    public function list(Request $request){
        if ($request->ajax()) {
            $lomba = LombaModel::with('tingkat', 'bidang', 'penyelenggara');

            if ($request->bidang_keahlian_id) {
                $lomba->where('bidang_keahlian_id', $request->bidang_keahlian_id);
            }

            $lomba = $lomba->get();


            return DataTables::of($lomba)
                ->addIndexColumn() // untuk DT_RowIndex
                ->addColumn('lomba kode', function ($row) {
                    return $row->lomba_kode;
                })
                ->addColumn('info', function ($row) {
                    return '
                            <div class="d-flex flex-column justify-content-center">
                                <div style="font-weight: bold;">' . $row->lomba_nama . '</div>
                                <div class="text-muted"><i class="fa fa-envelope me-1"></i> ' . $row->tingkat->tingkat_lomba_nama . '</div>
                                <div class="text-muted"><i class="fa fa-envelope me-1"></i> ' . $row->bidang->bidang_keahlian_nama . '</div>
                                <div class="text-muted"><i class="fa fa-phone me-1"></i> ' . $row->penyelenggara->penyelenggara_nama . '</div>
                            </div>
                        </div>
                    ';
                })
                ->addColumn('tanggal mulai', function ($row) {
                    return $row->tanggal_mulai ?? '-';
                })
                ->addColumn('tanggal selesai', function ($row) {
                    return $row->tanggal_selesai . '...';
                })
                ->addColumn('aksi', function ($row) {
                    $btn = '<button onclick="modalAction(\'' . url('/lomba/' . $row->lomba_id . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Detail</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/lomba/' . $row->lomba_id . '/edit') . '\')" class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-pen"></i> Edit</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/lomba/' . $row->lomba_id . '/delete') . '\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button> ';
                    // return '<div class="">' . $btn . '</div>';
                    return $btn;
                })
                ->rawColumns(['info', 'aksi']) // agar tombol HTML tidak di-escape
                ->make(true);
        }
    }

    public function show(LombaModel $lomba){
        $tingkat = TingkatLombaModel::all();
        $bidang = BidangKeahlianModel::all();
        $penyelenggara = PenyelenggaraModel::all();
        return view('admin.lomba.show_lomba')->with(['lomba' => $lomba, 'tingkat' => $tingkat, 'bidang' => $bidang, 'penyelenggara' => $penyelenggara]);
    }
    
}
