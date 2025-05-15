<?php

namespace App\Http\Controllers;

use App\Models\DosenModel;
use Illuminate\Http\Request;
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
                $image = $row->image ? asset('storage/' . $row->foto_profile) : asset('img/user.png');
                $image = asset('assets/images/user.png');

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

    public function show($id)
    {
        $dosen = DosenModel::find($id);
        return view('admin.dosen.show_dosen')->with(['dosen' => $dosen]);
    }
}
