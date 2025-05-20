<?php

namespace App\Http\Controllers;

use App\Models\BidangKeahlianModel;
use App\Models\LombaModel;
use App\Models\PenyelenggaraModel;
use App\Models\TingkatLombaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
                    $image = $row->foto_pamflet ? asset('storage/' . $row->foto_profile) : asset('assets/images/user.png');
                    return '
                    <div class="d-flex flex-column justify-content-center">
                                <div style="font-weight: bold;">' . $row->lomba_nama . '</div>
                                <div class="text-muted"><i class="fa fa-envelope me-1"></i> ' . $row->tingkat->tingkat_lomba_nama . '</div>
                                <div class="text-muted"><i class="fa fa-info"></i> ' . $row->bidang->bidang_keahlian_nama . '</div>
                                <div class="text-muted"><i class="fa fa-phone me-1"></i> ' . $row->penyelenggara->penyelenggara_nama . '</div>
                            </div>
                        </div>
                    ';
                })
                ->addColumn('deskripsi', function ($row) {
                    return collect(explode(' ', $row->lomba_deskripsi))->take(2)->implode(' ') . '...';
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
                        return '<span class="badge bg-danger" style="color: white;">Pending</span>';
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

        $dataToStore = $request->except('foto_pamflet');

        if ($request->hasFile('foto_pamflet')) {
            $file = $request->file('foto_pamflet');

            if (!$file->isValid()) {
                return response()->json(['error' => 'Invalid file'], 400);
            }

            // Simpan file ke direktori public/lomba/pamflet
            // Storage::disk('public')->putFile('lomba/pamflet', $file); // Ini akan menghasilkan nama file unik secara otomatis
            // Atau jika ingin nama file yang Anda definisikan:
            $filename = time() . '_' . $file->getClientOriginalName();
            $imagePath = 'lomba/pamflet/' . $filename; // Path relatif untuk database

            // Gunakan Storage facade untuk menyimpan file
            Storage::disk('public')->put($imagePath, file_get_contents($file));

            // Tambahkan path gambar ke data yang akan disimpan ke database
            $dataToStore['foto_pamflet'] = $imagePath;
        } else {
            // Jika tidak ada file yang diunggah, dan Anda ingin menyimpan null atau nilai default
            $dataToStore['foto_pamflet'] = null;
        }

        LombaModel::create($dataToStore);

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
            'tingkat_lomba_id' => 'required|exists:m_tingkat_lomba,tingkat_lomba_id',
            'bidang_keahlian_id' => 'required|exists:m_bidang_keahlian,bidang_keahlian_id',
            'penyelenggara_id' => 'required|exists:m_penyelenggara,penyelenggara_id',
            'tanggal_mulai' => 'required|date|date_format:Y-m-d',
            'tanggal_selesai' => 'required|date|date_format:Y-m-d',
            'foto_pamflet' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_verifikasi' => 'boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $dataToUpdate = $request->except(['foto_pamflet', 'status_verifikasi']); // Ambil semua data kecuali foto_pamflet

        // Penanganan unggahan gambar
        if ($request->hasFile('foto_pamflet')) {
            $file = $request->file('foto_pamflet');

            if (!$file->isValid()) {
                return response()->json(['error' => 'Invalid file'], 400);
            }

            // Hapus file lama jika ada
            if ($lomba->foto_pamflet && Storage::disk('public')->exists($lomba->foto_pamflet)) {
                Storage::disk('public')->delete($lomba->foto_pamflet);
            }

            // Simpan file baru
            $filename = time() . '_' . $file->getClientOriginalName();
            $imagePath = 'lomba/pamflet/' . $filename; // Path relatif untuk database

            Storage::disk('public')->put($imagePath, file_get_contents($file));

            // Tambahkan path gambar baru ke data yang akan diupdate
            $dataToUpdate['foto_pamflet'] = $imagePath;
        }
        // Jika tidak ada file baru yang diunggah, foto_pamflet tidak akan diubah dalam $dataToUpdate.
        // Jika Anda ingin mengizinkan penghapusan gambar (yaitu, mengatur foto_pamflet ke null),
        // Anda perlu mekanisme tambahan (misalnya, checkbox "Hapus Gambar" di form).

        // Update the LombaModel instance
        $dataToUpdate['status_verifikasi'] = $request->boolean('status_verifikasi');
        $lomba->update($dataToUpdate);

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
