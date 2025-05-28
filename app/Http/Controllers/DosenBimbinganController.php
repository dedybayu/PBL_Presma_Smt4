<?php

namespace App\Http\Controllers;

use App\Models\KelasModel;
use App\Models\MahasiswaModel;
use App\Models\ProdiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DosenBimbinganController extends Controller
{
    public function index(){
        $kelas = KelasModel::all();
        $prodi = ProdiModel::all();
        return view('dosen.daftar_mahasiswa')->with([
            'kelas' => $kelas,
            'prodi' => $prodi
        ]);
    }
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $mahasiswas = MahasiswaModel::with('kelas');

            if ($request->prodi_id) {
                $mahasiswas->whereHas('kelas', function ($query) use ($request) {
                    $query->where('prodi_id', $request->prodi_id);
                });
            }

            if ($request->kelas_id) {
                $mahasiswas->where('kelas_id', $request->kelas_id);
            }

            $mahasiswas = $mahasiswas->get();


            return DataTables::of($mahasiswas)
                ->addIndexColumn() // untuk DT_RowIndex
                ->addColumn('nim', function ($row) {
                    return $row->nim;
                })
                ->addColumn('info', function ($row) {
                    $image = $row->foto_profile ? asset('storage/' . $row->foto_profile) : asset('assets/images/user.png');
                    // $image = asset('assets/images/user.png');
    
                    return '
                        <div class="d-flex align-items-center text-start">
                            <img 
                                src="' . $image . '" 
                                alt="User image" 
                                class="rounded-circle" 
                                style="width: 40px; height: 40px; object-fit: cover; margin-right: 15px;"
                            >
                            <div class="d-flex flex-column justify-content-center">
                                <div style="font-weight: bold;">' . $row->nama . '</div>
                                <div class="text-muted"><i class="fa fa-envelope me-1"></i> ' . $row->email . '</div>
                                <div class="text-muted"><i class="fa fa-phone me-1"></i> ' . $row->no_tlp . '</div>
                            </div>
                        </div>
                    ';
                })
                ->addColumn('kelas', function ($row) {
                    return $row->kelas->kelas_nama ?? '-';
                })
                ->addColumn('alamat', function ($row) {
                    return collect(explode(' ', $row->alamat))->take(5)->implode(' ') . '...';
                })
                ->addColumn('aksi', function ($row) {
                    $btn = '<button onclick="modalAction(\'' . url('/mahasiswa_bimbingan/' . $row->mahasiswa_id . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Detail</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa_bimbingan/' . $row->mahasiswa_id . '/edit') . '\')" class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-pen"></i> Edit</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa_bimbingan/' . $row->mahasiswa_id . '/confirm-delete') . '\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button> ';
                    // return '<div class="">' . $btn . '</div>';
                    return $btn;
                })
                ->rawColumns(['info', 'aksi']) // agar tombol HTML tidak di-escape
                ->make(true);
        }
    }
}
