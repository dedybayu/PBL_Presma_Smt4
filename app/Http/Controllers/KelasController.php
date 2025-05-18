<?php

namespace App\Http\Controllers;

use App\Models\KelasModel;
use App\Models\ProdiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class KelasController extends Controller
{
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
                    $btn .= '<button onclick="modalAction(\'' . url('/kelas/' . $row->kelas_id . '/confirm-delete') . '\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function create()
    {
        $prodi = ProdiModel::all();
        return view('admin.kelas.create_kelas')->with([
            'prodi' => $prodi
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'kelas_kode' => 'required|string|max:50',
            'kelas_nama' => 'required|string|max:255',
            'prodi_id' => 'required|exists:m_prodi,prodi_id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        KelasModel::create([
            'kelas_kode' => $request->kelas_kode,
            'kelas_nama' => $request->kelas_nama,
            'prodi_id' => $request->prodi_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function show(KelasModel $kelas)
    {
        return view('admin.kelas.show_kelas')->with([
            'kelas' => $kelas
        ]);
    }

    public function edit(KelasModel $kelas)
    {
        $prodi = ProdiModel::all();
        return view('admin.kelas.edit_kelas')->with([
            'kelas' => $kelas,
            'prodi' => $prodi
        ]);
    }

    public function update(Request $request, KelasModel $kelas)
    {
        $rules = [
            'kelas_kode' => 'required|string|max:50',
            'kelas_nama' => 'required|string|max:255',
            'prodi_id' => 'required|exists:m_prodi,prodi_id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $kelas->update([
            'kelas_kode' => $request->kelas_kode,
            'kelas_nama' => $request->kelas_nama,
            'prodi_id' => $request->prodi_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diupdate.'
        ]);
    }

    public function confirmDelete(KelasModel $kelas)
    {
        return view('admin.kelas.confirm_delete_kelas')->with([
            'kelas' => $kelas
        ]);
    }

    public function destroy(KelasModel $kelas)
    {
        try {
            $kelas->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini'
            ]);
        }
    }
}