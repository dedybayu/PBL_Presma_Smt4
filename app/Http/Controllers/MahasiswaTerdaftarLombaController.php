<?php

namespace App\Http\Controllers;

use App\Models\LombaModel;
use App\Models\MahasiswaLombaModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MahasiswaTerdaftarLombaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lomba = LombaModel::where('status_verifikasi', 1)
            ->whereHas('mahasiswa_terdaftar') // nama relasi di model
            ->get();

        return view('admin.mahasiswa_lomba.daftar_mahasiswa_lomba')->with('lomba', $lomba);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $query = MahasiswaLombaModel::with([
                'mahasiswa',
                'lomba'
            ]);

            if ($request->lomba_id) {
                $query->where('lomba_id', $request->lomba_id);
            }

            $bidangKeahlian = $query->get();

            return DataTables::of($bidangKeahlian)
                ->addIndexColumn()
                ->addColumn('nama_lomba', function ($row) {
                    return $row->lomba->lomba_nama;
                })
                ->addColumn('mahasiswa_terdaftar', function ($row) {
                    return $row->mahasiswa->nama;
                })
                ->addColumn('nim', function ($row) {
                    return $row->mahasiswa->nim;
                })
                ->addColumn('status_verifikasi', function ($row) {
                    if ($row->status_verifikasi === 1) {
                        return '<button onclick="modalAction(\'' . url('/mahasiswa_lomba/' . $row->mahasiswa_lomba_id . '/edit-verifikasi') . '\')" class="badge bg-success" style="color: white; border: none; outline: none; box-shadow: none;">Disetujui</button>';
                    } else if ($row->status_verifikasi === 0) {
                        return '<button onclick="modalAction(\'' . url('/mahasiswa_lomba/' . $row->mahasiswa_lomba_id . '/edit-verifikasi') . '\')" class="badge bg-danger" style="color: white; border: none; outline: none; box-shadow: none;">Ditolak</button>';
                    } else if ($row->status_verifikasi === null) {
                        return '<button onclick="modalAction(\'' . url('/mahasiswa_lomba/' . $row->mahasiswa_lomba_id . '/edit-verifikasi') . '\')" class="badge bg-warning" style="color: white; border: none; outline: none; box-shadow: none;">Menunggu</button>';
                    }
                })
                ->addColumn('aksi', function ($row) {
                    $btn = '<button onclick="modalAction(\'' . url('/mahasiswa_lomba/' . $row->mahasiswa_lomba_id . '/show') . '\')" class="btn btn-info btn-sm mt-1 mb-1"><i class="fa fa-eye"></i> Detail</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa_lomba/' . $row->mahasiswa_lomba_id . '/edit') . '\')" class="btn btn-sm btn-warning mt-1 mb-1" title="Edit"><i class="fa fa-pen"></i> Edit</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa_lomba/' . $row->mahasiswa_lomba_id . '/confirm-delete') . '\')" class="btn btn-danger btn-sm mt-1 mb-1"><i class="fa fa-trash"></i> Hapus</button> ';
                    return $btn;
                })
                ->rawColumns(['status_verifikasi', 'aksi'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MahasiswaLombaModel $mahasiswaLombaModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MahasiswaLombaModel $mahasiswaLombaModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MahasiswaLombaModel $mahasiswaLombaModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MahasiswaLombaModel $mahasiswaLombaModel)
    {
        //
    }
}
