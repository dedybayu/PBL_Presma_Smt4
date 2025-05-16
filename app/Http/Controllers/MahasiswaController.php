<?php

namespace App\Http\Controllers;

use App\Models\KelasModel;
use App\Models\MahasiswaModel;
use App\Models\ProdiModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = KelasModel::all();
        $prodi = ProdiModel::all();
        return view('admin.mahasiswa.daftar_mahasiswa')->with([
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
                    $btn = '<button onclick="modalAction(\'' . url('/mahasiswa/' . $row->mahasiswa_id . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Detail</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa/' . $row->mahasiswa_id . '/edit') . '\')" class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-pen"></i> Edit</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/mahasiswa/' . $row->mahasiswa_id . '/confirm-delete') . '\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button> ';
                    // return '<div class="">' . $btn . '</div>';
                    return $btn;
                })
                ->rawColumns(['info', 'aksi']) // agar tombol HTML tidak di-escape
                ->make(true);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 'Ini Create';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mahasiswa = MahasiswaModel::find($id);
        // $kelas = KelasModel::select('kelas_id', 'kelas_nama');
        // $prodi = ProdiModel::select('prodi_id', 'prodi_nama');
        return view('admin.mahasiswa.show_mahasiswa')->with(['mahasiswa' => $mahasiswa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MahasiswaModel $mahasiswa)
    {
        // $mahasiswa = MahasiswaModel::find($id);

        $kelas = KelasModel::select('kelas_id', 'kelas_nama');
        $prodi = ProdiModel::select('prodi_id', 'prodi_nama');
        return view('admin.mahasiswa.edit_mahasiswa')->with(['kelas' => $kelas, 'prodi' => $prodi, 'mahasiswa' => $mahasiswa]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MahasiswaModel $mahasiswa)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // dd($request);
            // dd($request->file('foto_profile'));

            $rules = [
                'username' => 'required|max:20|unique:m_user,username,' . $mahasiswa->user->user_id . ',user_id',
                'nama' => 'required|max:100',
                'password' => 'nullable|min:6|max:20'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }
            if ($request->hasFile('foto_profile')) {
                // return response()->json(['error' => 'No file uploaded'], 400);
                $file = $request->file('foto_profile');

                if (!$file->isValid()) {
                    return response()->json(['error' => 'Invalid file'], 400);
                }

                // Nama file unik
                $filename = time() . '_' . $file->getClientOriginalName();

                // Pastikan folder penyimpanan ada
                $destinationPath = storage_path('app/public/mahasiswa/profile-pictures');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0775, true);
                }

                // Hapus file lama jika ada
                $oldImage = $mahasiswa->foto_profile ?? null; // Ambil path file lama dari database

                if ($oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }

                // Pindahkan file
                $file->move($destinationPath, $filename);

                $imagePath = "mahasiswa/profile-pictures/$filename"; // Simpan path gambar
            } else {
                $imagePath = null;
                // return  'dijalankan';
            }

            // return 'aaaa'.$imagePath;

            $check = UserModel::find($mahasiswa->user->user_id);
            if ($check) {
                if (!$request->filled('password')) {
                    $data_user = [
                        'username' => $request->username,
                    ];
                } else {
                    $data_user = [
                        'username' => $request->username,
                        'password' => $request->password
                    ];
                }
                $check->update($data_user);

                if ($request->input('remove_picture') == "1") {
                    // Hapus gambar lama jika ada
                    if ($mahasiswa->foto_profile) {
                        $oldImage = $mahasiswa->foto_profile; // Ambil path file lama dari database
                        if ($oldImage) {
                            Storage::disk('public')->delete($oldImage);
                        }
                    }
                    $imagePath = null; // Set kolom di database jadi null
                }

                $data_mahasiswa = [
                    'nim' => $request->nim,
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'no_tlp' => $request->no_tlp,
                    'alamat' => $request->alamat,
                    'tahun_angkatan' => $request->tahun_angkatan,
                    'foto_profile' => $imagePath
                ];
                $mahasiswa->update($data_mahasiswa);
                return response()->json(['status' => true, 'message' => 'Data berhasil diupdate']);
            } else {
                return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
            }
        }
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function confirmDelete(MahasiswaModel $mahasiswa)
    {
        $kelas = KelasModel::select('kelas_id', 'kelas_nama');
        $prodi = ProdiModel::select('prodi_id', 'prodi_nama');
        return view('admin.mahasiswa.confirm_delete_mahasiswa')->with(['kelas' => $kelas, 'prodi' => $prodi, 'mahasiswa' => $mahasiswa]);
    }

    public function destroy(MahasiswaModel $mahasiswa)
    {
        // return $mahasiswa;
        if ($mahasiswa) {
            try {
                $oldImage = $mahasiswa->foto_profile; // Ambil path file lama dari database
                if ($oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
                $mahasiswa->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini'
                ]);
            }
        }
    }
}
