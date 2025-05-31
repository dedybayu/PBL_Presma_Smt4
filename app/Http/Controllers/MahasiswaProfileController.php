<?php

namespace App\Http\Controllers;

use App\Models\KeahlianMahasiswaModel;
use App\Models\KelasModel;
use App\Models\MahasiswaModel;
use App\Models\MahasiswaOrganisasiModel;
use App\Models\MinatMahasiswaModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Storage;
use Validator;
use Yajra\DataTables\DataTables;

class MahasiswaProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = KelasModel::all();
        return view('mahasiswa.profile.profile_mahasiswa')->with([
            'kelas' => $kelas
        ]);
    }

    public function list_minat(Request $request)
    {
        if ($request->ajax()) {
            $minatMahasiswa = MinatMahasiswaModel::where('mahasiswa_id', auth()->user()->mahasiswa->mahasiswa_id)->with('bidang_keahlian')->get();

            // $kategoriBidangKeahlian = $query->get();

            return DataTables::of($minatMahasiswa)
                ->addIndexColumn()
                ->addColumn('bidang_keahlian_nama', function ($row) {
                    return $row->bidang_keahlian->bidang_keahlian_nama;
                })
                ->addColumn('aksi', function ($row) {
                    $btn = '<button onclick="modalProfile(\'' . url('/profile/mahasiswa/minat/' . $row->minat_mahasiswa_id. '/delete') . '\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button> ';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }
    public function list_organisasi(Request $request)
    {
        if ($request->ajax()) {
            $organisasiMahasiswa = MahasiswaOrganisasiModel::where('mahasiswa_id', auth()->user()->mahasiswa->mahasiswa_id)->with('organisasi')->get();

            // $kategoriBidangKeahlian = $query->get();

            return DataTables::of($organisasiMahasiswa)
                ->addIndexColumn()
                ->addColumn('organisasi_nama', function ($row) {
                    return $row->organisasi->organisasi_nama;
                })
                ->addColumn('aksi', function ($row) {
                    $btn = '<button onclick="modalProfile(\'' . url('/profile/mahasiswa/organisasi/' . $row->mahasiswa_organisasi_id. '/delete') . '\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button> ';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function list_keahlian(Request $request)
    {
        if ($request->ajax()) {
            $keahlianMahasiswa = KeahlianMahasiswaModel::where('mahasiswa_id', auth()->user()->mahasiswa->mahasiswa_id)->with('bidang_keahlian')->get();

            // $kategoriBidangKeahlian = $query->get();

            return DataTables::of($keahlianMahasiswa)
                ->addIndexColumn()
                ->addColumn('bidang_keahlian_nama', function ($row) {
                    return $row->bidang_keahlian->bidang_keahlian_nama;
                })
                ->addColumn('aksi', function ($row) {
                    $btn = '<button onclick="modalProfile(\'' . url('/profile/mahasiswa/keahlian/' . $row->keahlian_mahasiswa_id . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Detail</button> ';
                    $btn .= '<button onclick="modalProfile(\'' . url('/profile/mahasiswa/keahlian/' . $row->keahlian_mahasiswa_id . '/edit') . '\')" class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-pen"></i> Edit</button> ';
                    $btn .= '<button onclick="modalProfile(\'' . url('/profile/mahasiswa/keahlian/' . $row->keahlian_mahasiswa_id . '/delete') . '\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button> ';                    return $btn;
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
    public function show(MahasiswaModel $mahasiswaModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MahasiswaModel $mahasiswaModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $mahasiswa = auth()->user()->mahasiswa;
        if ($request->ajax() || $request->wantsJson()) {
            // dd($request);
            // dd($request->file('foto_profile'));

            $rules = [
                'username' => 'required|max:20|unique:m_user,username,' . $mahasiswa->user->user_id . ',user_id',
                'email' => 'required|email|unique:m_mahasiswa,email,' . $mahasiswa->mahasiswa_id . ',mahasiswa_id',
                'alamat' => 'required|max:200',
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
                $destinationPath = storage_path('app/public/mahasiswa/' . $mahasiswa->nim . '/profile-pictures');
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

                $imagePath = "mahasiswa/$mahasiswa->nim/profile-pictures/$filename"; // Simpan path gambar
            } else {
                $imagePath = null;
                // return  'dijalankan';
            }

            // return 'aaaa'.$imagePath;

            $check = UserModel::find($mahasiswa->user->user_id);
            if ($check) {
                // if (!$request->filled('password')) {
                //     $data_user = [
                //         'username' => $request->username,
                //     ];
                // } else {
                $data_user = [
                    'username' => $request->username,
                    // 'password' => $request->password
                ];
                // }
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
                    'email' => $request->email,
                    // 'no_tlp' => $request->no_tlp,
                    'alamat' => $request->alamat,
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



    // MINAT KEAHLIAN DAN ORGANISASI

    //KEAHLIAN MAHASISWA
    public function confirm_keahlian(MinatMahasiswaModel $keahlian)
    {
        return 'hello delete keahlian';
    }

    //MINAT MAHASISWA
    public function confirm_minat(MinatMahasiswaModel $minat)
    {
        return 'hello delete minat';
    }

    //ORGANISASI MAHASISWA
    public function confirm_organisasi(MahasiswaOrganisasiModel $organisasi)
    {
        return 'hello delete organisasi';
    }
}
