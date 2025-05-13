<?php

namespace App\Http\Controllers;

use App\Models\ProdiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.prodi.daftar_prodi');
    }

    /**
     * Display a listing of Prodi data in DataTables.
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {

            $prodi = ProdiModel::select('prodi_id', 'prodi_kode', 'prodi_nama');


            if ($request->prodi_nama) {
                $prodi->where('prodi_nama', 'like', '%' . $request->prodi_nama . '%');
            }


            return DataTables::of($prodi)
                ->addIndexColumn()
                ->addColumn('info', function ($row) {
                    return '
                        <strong>' . $row->prodi_nama . '</strong><br>
                        <small>Kode: ' . $row->prodi_kode . '</small>
                    ';
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <a href="' . route('prodi.edit', $row->prodi_id) . '" class="btn btn-warning btn-sm">Edit</a>
                        <button data-url="' . route('prodi.destroy', $row->prodi_id) . '" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                    ';
                })
                ->rawColumns(['info', 'aksi'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
       
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {

    }
}
