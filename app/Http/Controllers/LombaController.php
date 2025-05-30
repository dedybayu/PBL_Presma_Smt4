<?php

namespace App\Http\Controllers;

use App\Models\BidangKeahlianModel;
use App\Models\LombaModel;
use App\Models\PenyelenggaraModel;
use App\Models\TingkatLombaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;
use Yajra\DataTables\Facades\DataTables;

class LombaController extends Controller
{
    public function index(LombaModel $lomba)
    {
        $tingkat = TingkatLombaModel::all();
        $bidang = BidangKeahlianModel::all();
        $penyelenggara = PenyelenggaraModel::all();
        return view('admin.lomba.daftar_lomba')->with(['lomba' => $lomba, 'tingkat' => $tingkat, 'bidang' => $bidang, 'penyelenggara' => $penyelenggara]);
    }

    public function list(Request $request)
    {
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
                    $image = $row->foto_pamflet ? asset('storage/' . $row->foto_pamflet) : asset('assets/images/user.png');
                    return '
                    <div class="d-flex flex-column">
                        <div class="fw-bold text-truncate mb-1" style="max-width: 100%;">'
                            .$row->lomba_nama.
                        '</div>

                        <div class="text-muted text-truncate mb-1" style="max-width: 100%;">
                            <small>
                                <i class="fa fa-envelope me-1"> </i>' .$row->tingkat->tingkat_lomba_nama.
                            '</small>
                        </div>

                        <div class="text-muted text-truncate mb-1" style="max-width: 100%;">
                            <small>
                                <i class="fa fa-info me-1"> </i> '.$row->bidang->bidang_keahlian_nama.'
                            </small>
                        </div>

                        <div class="text-muted text-truncate mb-1" style="max-width: 100%;">
                            <small>
                                <i class="fa fa-building me-1"> </i>
                                '.$row->penyelenggara->penyelenggara_nama.'
                            </small>
                        </div>
                    </div>
                    ';
                })
                ->addColumn('deskripsi', function ($row) {
                    // return collect(explode(' ', $row->lomba_deskripsi))->take(5)->implode(' ') . '...';
                    return collect(explode(' ', $row->lomba_deskripsi))->take(3)->implode(' ') . '...';
                })
                ->addColumn('tanggal mulai', function ($row) {
                    return $row->tanggal_mulai ?? '-';
                })
                ->addColumn('tanggal selesai', function ($row) {
                    return $row->tanggal_selesai . '...';
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
                    $btn = '<button onclick="modalAction(\'' . url('/lomba/' . $row->lomba_id . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Detail</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/lomba/' . $row->lomba_id . '/edit') . '\')" class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-pen"></i> Edit</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/lomba/' . $row->lomba_id . '/delete') . '\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button> ';
                    // return '<div class="">' . $btn . '</div>';
                    return $btn;
                })
                ->rawColumns(['info', 'aksi', 'status_verifikasi']) // agar tombol HTML tidak di-escape
                ->make(true);
        }
    }

    public function create()
    {
        $tingkat = TingkatLombaModel::all();
        $bidang = BidangKeahlianModel::all();
        $penyelenggara = PenyelenggaraModel::all();
        return view('admin.lomba.create_lomba')->with(['tingkat' => $tingkat, 'bidang' => $bidang, 'penyelenggara' => $penyelenggara]);
    }

    public function store(Request $request)
    {
        $rules = [
            'lomba_kode' => 'required|string|max:255',
            'lomba_nama' => 'required|string|max:255',
            'lomba_deskripsi' => 'required|string|max:255',
            'link_website' => 'required|string|max:255',
            'tingkat_lomba_id' => 'required|exists:m_tingkat_lomba,tingkat_lomba_id',
            'bidang_keahlian_id' => 'required|exists:m_bidang_keahlian,bidang_keahlian_id',
            'penyelenggara_id' => 'required|exists:m_penyelenggara,penyelenggara_id',
            'tanggal_mulai' => 'required|date|date_format:Y-m-d',
            'tanggal_selesai' => 'required|date|date_format:Y-m-d',
            'foto_pamflet' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $imagePath = null;
        if ($request->hasFile('foto_pamflet')) {
            $file = $request->file('foto_pamflet');
    
            if (!$file->isValid()) {
                return response()->json(['error' => 'Invalid file'], 400);
            }
    
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = storage_path('app/public/lomba/foto-pamflet');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }
    
            $file->move($destinationPath, $filename);
            $imagePath = "lomba/foto-pamflet/$filename"; // Simpan path gambar
        }

        try {
            $lomba = LombaModel::create([
                'lomba_kode' => $request->lomba_kode,
                'lomba_nama' => $request->lomba_nama,
                'lomba_deskripsi' => $request->lomba_deskripsi,
                'link_website' => $request->link_website,
                'tingkat_lomba_id' => $request->tingkat_lomba_id,
                'bidang_keahlian_id' => $request->bidang_keahlian_id,
                'penyelenggara_id' => $request->penyelenggara_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'foto_pamflet' => $imagePath,
                'status_verifikasi' => $request->status_verifikasi
            ]);
        } catch (\Throwable $e) {
            if (isset($lomba)) {
                $lomba->delete();
            }
            return response()->json(['status' => false, 'message' => 'Gagal menambahkan data baru: ' . $e->getMessage()], 500);
        }
       

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function show(LombaModel $lomba)
    {
        $tingkat = TingkatLombaModel::all();
        $bidang = BidangKeahlianModel::all();
        $penyelenggara = PenyelenggaraModel::all();
        return view('admin.lomba.show_lomba')->with(['lomba' => $lomba, 'tingkat' => $tingkat, 'bidang' => $bidang, 'penyelenggara' => $penyelenggara]);
    }

    public function edit(LombaModel $lomba)
    {
        $tingkat = TingkatLombaModel::all();
        $bidang = BidangKeahlianModel::all();
        $penyelenggara = PenyelenggaraModel::all();
        return view('admin.lomba.edit_lomba')->with(['lomba' => $lomba, 'tingkat' => $tingkat, 'bidang' => $bidang, 'penyelenggara' => $penyelenggara]);
    }

    public function update(Request $request, LombaModel $lomba)
    {
        $rules = [
            'lomba_kode' => 'required|string|max:255',
            'lomba_nama' => 'required|string|max:255',
            'lomba_deskripsi' => 'required|string|max:255',
            'link_website' => 'required|string|max:255',
            'tingkat_lomba_id' => 'required|exists:m_tingkat_lomba,tingkat_lomba_id',
            'bidang_keahlian_id' => 'required|exists:m_bidang_keahlian,bidang_keahlian_id',
            'penyelenggara_id' => 'required|exists:m_penyelenggara,penyelenggara_id',
            'tanggal_mulai' => 'required|date|date_format:Y-m-d',
            'tanggal_selesai' => 'required|date|date_format:Y-m-d',
            'foto_pamflet' => 'nullable|mimes:jpeg,png,jpg',
            'status_verifikasi' => 'required|integer|in:0,1,2'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }
        $imagePath = null;
        if ($request->hasFile('foto_pamflet')) {
            $file = $request->file('foto_pamflet');
    
            if (!$file->isValid()) {
                return response()->json(['error' => 'Invalid file'], 400);
            }
    
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = storage_path('app/public/lomba/foto-pamflet');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }
    
            $file->move($destinationPath, $filename);
            $imagePath = "lomba/foto-pamflet/$filename"; // Simpan path gambar
        }

        $update_data =[
            'lomba_kode' => $request->lomba_kode,
            'lomba_nama' => $request->lomba_nama,
            'lomba_deskripsi' => $request->lomba_deskripsi,
            'link_website' => $request->link_website,
            'tingkat_lomba_id' => $request->tingkat_lomba_id,
            'bidang_keahlian_id' => $request->bidang_keahlian_id,
            'penyelenggara_id' => $request->penyelenggara_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'foto_pamflet' => $imagePath,
            'status_verifikasi' => $request->status_verifikasi
        ];

        $lomba->update($update_data);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui.'
        ]);
    }

    public function confirm(LombaModel $lomba)
    {
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
