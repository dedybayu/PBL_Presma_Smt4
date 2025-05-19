<?php

namespace App\Http\Controllers;

use App\Models\BidangKeahlianModel;
use App\Models\LombaModel;
use App\Models\PenyelenggaraModel;
use App\Models\TingkatLombaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

    public function create(){
        $tingkat = TingkatLombaModel::all();
        $bidang = BidangKeahlianModel::all();
        $penyelenggara = PenyelenggaraModel::all();
        return view('admin.lomba.create_lomba')->with(['tingkat' => $tingkat, 'bidang' => $bidang, 'penyelenggara' => $penyelenggara]);
    }

    public function store(Request $request){
        $rules = [
            'lomba_kode' => 'required|string|max:255',
            'lomba_nama' => 'required|string|max:255',
            'tingkat_lomba_id' => 'required|exists:m_tingkat_lomba,tingkat_lomba_id',
            'bidang_keahlian_id' => 'required|exists:m_bidang_keahlian,bidang_keahlian_id',
            'penyelenggara_id' => 'required|exists:m_penyelenggara,penyelenggara_id',
            'tanggal_mulai' => 'required|date|date_format:Y-m-d',
            'tanggal_selesai' => 'required|date|date_format:Y-m-d',
            'status_verifikasi'=> 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        LombaModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function show(LombaModel $lomba){
        $tingkat = TingkatLombaModel::all();
        $bidang = BidangKeahlianModel::all();
        $penyelenggara = PenyelenggaraModel::all();
        return view('admin.lomba.show_lomba')->with(['lomba' => $lomba, 'tingkat' => $tingkat, 'bidang' => $bidang, 'penyelenggara' => $penyelenggara]);
    }

    public function edit(LombaModel $lomba){
        $tingkat = TingkatLombaModel::all();
        $bidang = BidangKeahlianModel::all();
        $penyelenggara = PenyelenggaraModel::all();
        return view('admin.lomba.edit_lomba')->with(['lomba' => $lomba, 'tingkat' => $tingkat, 'bidang' => $bidang, 'penyelenggara' => $penyelenggara]);
    }

    public function update(Request $request){
        $rules = [
            'lomba_kode' => 'required|string|max:255',
            'lomba_nama' => 'required|string|max:255',
            'tingkat_lomba_id' => 'required|exists:m_tingkat_lomba,tingkat_lomba_id',
            'bidang_keahlian_id' => 'required|exists:m_bidang_keahlian,bidang_keahlian_id',
            'penyelenggara_id' => 'required|exists:m_penyelenggara,penyelenggara_id',
            'tanggal_mulai' => 'required|date|date_format:Y-m-d',
            'tanggal_selesai' => 'required|date|date_format:Y-m-d',
            'status_verifikasi'=> 'required|integer'
        ];

        $validator = Validator::update($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        LombaModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function confirm(LombaModel $lomba){
        $tingkat = TingkatLombaModel::all();
        $bidang = BidangKeahlianModel::all();
        $penyelenggara = PenyelenggaraModel::all();
        return view('admin.lomba.confirm_lomba')->with(['lomba' => $lomba, 'tingkat' => $tingkat, 'bidang' => $bidang, 'penyelenggara' => $penyelenggara]);
    }

    public function destroy(LombaModel $lomba)
    {
        try {
            $lomba->delete();

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
