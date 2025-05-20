<?php

namespace App\Http\Controllers;

use App\Models\DosenModel;
use App\Models\LombaModel;
use App\Models\MahasiswaModel;
use App\Models\PrestasiModel;
use App\Models\TingkatLombaModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tingkat_lomba = TingkatLombaModel::all();
        return view('admin.prestasi.daftar_prestasi')->with([
            'tingkat_lomba' => $tingkat_lomba
        ]);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $prestasi = PrestasiModel::with('mahasiswa', 'dosen', 'lomba.tingkat');

            if ($request->tingkat_lomba_id) {
                $prestasi->whereHas('lomba.tingkat', function ($query) use ($request) {
                    $query->where('tingkat_lomba_id', $request->tingkat_lomba_id);
                });
            }

            $prestasi = $prestasi->get();

            return DataTables::of($prestasi)
                ->addIndexColumn() // untuk DT_RowIndex
                ->addColumn('nim', function ($row) {
                    return $row->mahasiswa->nim;
                })

                // ->addColumn('info', function ($row) {
                //     $image = $row->foto_profile ? asset('storage/' . $row->foto_profile) : asset('assets/images/user.png');
                //     // $image = asset('assets/images/user.png');

                //     return '
                //         <div class="d-flex align-items-center text-start">
                //             <img 
                //                 src="' . $image . '" 
                //                 alt="User image" 
                //                 class="rounded-circle" 
                //                 style="width: 40px; height: 40px; object-fit: cover; margin-right: 15px;"
                //             >
                //             <div class="d-flex flex-column justify-content-center">
                //                 <div style="font-weight: bold;">' . $row->nama . '</div>
                //                 <div class="text-muted"><i class="fa fa-envelope me-1"></i> ' . $row->email . '</div>
                //                 <div class="text-muted"><i class="fa fa-phone me-1"></i> ' . $row->no_tlp . '</div>
                //             </div>
                //         </div>
                //     ';
                // })

                ->addColumn('mahasiswa', function ($row) {
                    return $row->mahasiswa->nama ?? '-';
                })
                ->addColumn('prestasi', function ($row) {
                    return collect(explode(' ', $row->prestasi_nama))->take(4)->implode(' ') . '...';
                })
                ->addColumn('lomba', function ($row) {
                    return collect(explode(' ', $row->lomba->lomba_nama))->take(4)->implode(' ') . '...';
                })
                ->addColumn('juara', function ($row) {
                    return $row->nama_juara ?? '-';
                })
                ->addColumn('tingkat', function ($row) {
                    return $row->lomba->tingkat->tingkat_lomba_nama ?? '-';
                })
                ->addColumn('poin', function ($row) {
                    return $row->poin ?? '-';
                })
                ->addColumn('status_verifikasi', function ($row) {
                    if ($row->status_verifikasi == 1) {
                        return '<span class="badge bg-success" style="color: white;">Terverifikasi</span>';
                    } else if ($row->status_verifikasi == 0) {
                        return '<span class="badge bg-danger" style="color: white;">Ditolak</span>';
                    } else {
                        return '<span class="badge bg-warning"style="color: white;">Belum Diverifikasi</span>';
                    }
                })
                ->addColumn('aksi', function ($row) {
                    $btn = '<button onclick="modalAction(\'' . url('/mahasiswa/' . $row->mahasiswa_id . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Detail</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa/' . $row->mahasiswa_id . '/edit') . '\')" class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-pen"></i> Edit</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa/' . $row->mahasiswa_id . '/confirm-delete') . '\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button> ';
                    // return '<div class="">' . $btn . '</div>';
                    return $btn;
                })
                ->rawColumns(['info', 'aksi', 'status_verifikasi']) // agar tombol HTML tidak di-escape
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lomba = LombaModel::where('tanggal_selesai', '<', Carbon::now())
            ->where('status_verifikasi', 1)
            ->get();

        $dosen = DosenModel::all();
        $mahasiswa = MahasiswaModel::all();
        return view('admin.prestasi.create_prestasi')->with([
            'lomba' => $lomba,
            'dosen' => $dosen,
            'mahasiswa' => $mahasiswa
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(PrestasiModel $prestasiModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrestasiModel $prestasiModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrestasiModel $prestasiModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrestasiModel $prestasiModel)
    {
        //
    }
}
