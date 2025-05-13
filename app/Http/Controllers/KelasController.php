<?php

namespace App\Http\Controllers;

use App\Models\KelasModel;
use App\Models\ProdiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prodi = ProdiModel::all();
        return view('admin.kelas.daftar_kelas')->with([
            'prodi' => $prodi
        ]);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $kelas = KelasModel::with('prodi');

            if ($request->prodi_id) {
                $kelas->where('prodi_id', $request->prodi_id);
            }

            $kelas = $kelas->get();

            return DataTables::of($kelas)
                ->addIndexColumn()
                ->addColumn('kode', function ($row) {
                    return $row->kelas_kode;
                })
                ->addColumn('nama', function ($row) {
                    return $row->kelas_nama;
                })
                ->addColumn('prodi', function ($row) {
                    return $row->prodi->prodi_nama ?? '-';
                })
                ->addColumn('aksi', function ($row) {
                    $btn = '<button onclick="modalAction(\'' . url('/kelas/' . $row->kelas_id . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Detail</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/kelas/' . $row->kelas_id . '/edit') . '\')" class="btn btn-warning btn-sm"><i class="fa fa-pen"></i> Edit</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/kelas/' . $row->kelas_id . '/delete') . '\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
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
    public function show(KelasModel $kelasModel)
    {
        $prodi = ProdiModel::select('prodi_id', 'prodi_nama')->get();
        return view('admin.kelas.show')->with([
            'kelas' => $kelasModel,
            'prodi' => $prodi
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KelasModel $kelasModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KelasModel $kelasModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KelasModel $kelasModel)
    {
        //
    }
}