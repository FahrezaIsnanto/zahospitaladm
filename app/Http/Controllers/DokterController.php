<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;


class DokterController extends Controller
{
    public function index()
    {
        $dokter = DB::table('dokter');

        if (!empty(Request::input("search"))) {
            $dokter->where('nama_dokter', 'like', '%' . Request::input("search") . '%');
        }

        if (!empty(Request::input("trashed"))) {
            if (Request::input("trashed") === "only") {
                $dokter->whereNotNull('deleted_at');
            }
        }

        return Inertia::render('Dokter/Index', [
            'filters' => Request::all('search', 'trashed'),
            'dokter' => [
                "data" => $dokter->get(),
                "links" => $dokter->paginate(15)
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Dokter/Create');
    }

    public function store()
    {
        Request::validate([
            'namaDokter' => ['required'],
            'spesialis' => ['required']
        ]);

        DB::insert("insert into dokter (nama_dokter, spesialis) values (:nama_dokter, :spesialis)", [
            'nama_dokter' => Request::input('namaDokter'),
            'spesialis' => Request::input('spesialis'),
        ]);

        return Redirect::route('dokter')->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $dokter = DB::select("select * from dokter where id_dokter = :id_dokter", [
            "id_dokter" => $id
        ])[0];

        return Inertia::render('Dokter/Edit', [
            'dokter' => $dokter
        ]);
    }

    public function update($id)
    {
        Request::validate([
            'namaDokter' => ['required'],
            'spesialis' => ['required']
        ]);

        DB::update("update dokter set nama_dokter = :nama_dokter, spesialis = :spesialis where id_dokter = :id_dokter", [
            'nama_dokter' => Request::input('namaDokter'),
            'spesialis' => Request::input('spesialis'),
            'id_dokter' => $id
        ]);

        return Redirect::back()->with('success', 'Dokter berhasil diupdate.');
    }

    public function destroy($id)
    {
        DB::update("update dokter set deleted_at = :deleted_at where id_dokter = :id_dokter", [
            'deleted_at' => date("Y-m-d h:i:s"),
            'id_dokter' => $id
        ]);

        return Redirect::back()->with('success', 'Dokter berhasil dihapus.');
    }

    public function restore($id)
    {
        DB::update("update dokter set deleted_at = :deleted_at where id_dokter = :id_dokter", [
            'deleted_at' => null,
            'id_dokter' => $id
        ]);

        return Redirect::back()->with('success', 'Dokter berhasil dipulihkan.');
    }
}
