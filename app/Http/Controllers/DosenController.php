<?php

namespace App\Http\Controllers;

use App\Models\DosenModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DosenController extends Controller
{

    public function index()
    {
        $dosen = DosenModel::all();
        return view("admin.dosen.daftar_dosen")->with(["dosen" => $dosen]);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $dosen = DosenModel::select("dosen_id", "nidn", "nama", "email", "no_tlp", "foto_profile");

            if ($request->dosen_id) {
                $dosen->where('dosen_id', $request->dosen_id);
            }
        }
        $dosen = $dosen->get();
        return DataTables::of($dosen)
            ->addIndexColumn() // untuk DT_RowIndex
            ->addColumn('nidn', function ($row) {
                return $row->nidn;
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
            ->addColumn('aksi', function ($row) {
                $btn = '<button onclick="modalAction(\'' . url('/dosen/' . $row->dosen_id . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/dosen/' . $row->dosen_id . '/edit') . '\')" class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-pen"></i> Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/dosen/' . $row->dosen_id . '/delete') . '\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button> ';
                // return '<div class="">' . $btn . '</div>';
                return $btn;
            })
            ->rawColumns(['info', 'aksi']) // agar tombol HTML tidak di-escape
            ->make(true);
    }

    public function create(DosenModel $dosen){
        return view('admin.dosen.create_dosen')->with($dosen);
    }

    public function store(Request $request){
        if ($request->ajax() || $request->wantsJson()) {
            // dd($request);
            // dd($request->file('foto_profile'));
            if ($request->ajax() || $request->wantsJson()) {
                $rules_user = [
                    'username' => 'required|max:20|unique:m_user,username',
                    'password' => 'required|min:6|max:20'
                ];
                $rules_dosen = [
                    'nidn' => 'required',
                    'nama' => 'required|max:100',
                    'email' => 'required|email|max:255',
                    'no_tlp' => 'nullable|max:20',
                ];
            
                $validator_user = Validator::make($request->only(['username', 'password']), $rules_user);
                $validator_dosen = Validator::make($request->only(['nidn', 'nama', 'email', 'no_tlp']), $rules_dosen);
            
                if ($validator_user->fails() || $validator_dosen->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Validasi gagal.',
                        'msgField' => array_merge($validator_user->errors()->toArray(), $validator_dosen->errors()->toArray())
                    ]);
                }
            
                $imagePath = null;
                if ($request->hasFile('foto_profile')) {
                    $file = $request->file('foto_profile');
            
                    if (!$file->isValid()) {
                        return response()->json(['error' => 'Invalid file'], 400);
                    }
            
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $destinationPath = storage_path('app/public/dosen/profile-pictures');
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0775, true);
                    }
            
                    $file->move($destinationPath, $filename);
                    $imagePath = "dosen/profile-pictures/$filename"; // Simpan path gambar
                }
            
                try {
                    // Buat user baru
                    $user = UserModel::create([
                        'username' => $request->username,
                        'password' => bcrypt($request->password),
                        'level_id' => 2, // Asumsi level_id untuk dosen adalah 2
                    ]);
            
                    // Buat dosen baru
                    $dosen = DosenModel::create([
                        'user_id' => $user->user_id,
                        'nidn' => $request->nidn,
                        'nama' => $request->nama,
                        'email' => $request->email,
                        'no_tlp' => $request->no_tlp,
                        'foto_profile' => $imagePath,
                    ]);
            
                    return response()->json(['status' => true, 'message' => 'Data dosen berhasil ditambahkan', 'data' => $dosen]);
            
                } catch (\Exception $e) {
                    // Jika terjadi error saat membuat user atau dosen, hapus user yang mungkin sudah terbuat
                    if (isset($user)) {
                        $user->delete();
                    }
                    return response()->json(['status' => false, 'message' => 'Gagal menambahkan data dosen: ' . $e->getMessage()], 500);
                }
            }
            return redirect('/dosen'); // Redirect jika bukan request AJAX
    }
}

    public function show($id)
    {
        $dosen = DosenModel::find($id);
        return view('admin.dosen.show_dosen')->with(['dosen' => $dosen]);
    }

    public function edit(DosenModel $dosen)
    {
        return view('admin.dosen.edit_dosen')->with(['dosen' => $dosen]);
    }

    public function update(Request $request, DosenModel $dosen)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // dd($request);
            // dd($request->file('foto_profile'));

            $rules = [
                'username' => 'required|max:20|unique:m_user,username,' . $dosen->user->user_id . ',user_id',
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
                $destinationPath = storage_path('app/public/dosen/profile-pictures');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0775, true);
                }

                // Hapus file lama jika ada
                $oldImage = $dosen->foto_profile ?? null; // Ambil path file lama dari database

                if ($oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }

                // Pindahkan file
                $file->move($destinationPath, $filename);

                $imagePath = "dosen/profile-pictures/$filename"; // Simpan path gambar
            } else {
                $imagePath = null;
                // return  'dijalankan';
            }

            // return 'aaaa'.$imagePath;

            $check = UserModel::find($dosen->user->user_id);
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
                    if ($dosen->foto_profile) {
                        $oldImage = $dosen->foto_profile; // Ambil path file lama dari database
                        if ($oldImage) {
                            Storage::disk('public')->delete($oldImage);
                        }
                    }
                    $imagePath = null; // Set kolom di database jadi null
                }

                $data_dosen = [
                    'nidn' => $request->nidn,
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'no_tlp' => $request->no_tlp,
                    'foto_profile' => $imagePath
                ];
                $dosen->update($data_dosen);
                return response()->json(['status' => true, 'message' => 'Data berhasil diupdate']);
            } else {
                return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
            }
        }
        return redirect('/');
    }

    public function delete(DosenModel $dosen)
    {
        return view('admin.dosen.confirm_delete')->with(['dosen' => $dosen]);
    }

    public function destroy(DosenModel $dosen)
    {
        if ($dosen) {
            try {
                $oldImage = $dosen->foto_profile; // Ambil path file lama dari database
                if ($oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
                $dosen->delete();
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
