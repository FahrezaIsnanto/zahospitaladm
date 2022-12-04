<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class KlinikController extends Controller
{
    public function index()
    {
        $klinik = DB::table('klinik');

        if (!empty(Request::input("search"))) {
            $klinik->where('nama_klinik', 'like', '%' . Request::input("search") . '%');
        }

        if (!empty(Request::input("trashed"))) {
            if (Request::input("trashed") === "only") {
                $klinik->whereNotNull('deleted_at');
            }
        }

        return Inertia::render('Klinik/Index', [
            'filters' => Request::all('search', 'trashed'),
            'klinik' => [
                "data" => $klinik->get(),
                "links" => $klinik->paginate(15)
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Klinik/Create');
    }

    public function store()
    {
        Request::validate([
            'namaKlinik' => ['required']
        ]);

        DB::insert("insert into klinik (nama_klinik) values (:nama_klinik)", [
            'nama_klinik' => Request::input('namaKlinik')
        ]);

        return Redirect::route('klinik')->with('success', 'Klinik berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $klinik = DB::select("select * from klinik where id_klinik = :id_klinik", [
            "id_klinik" => $id
        ])[0];

        return Inertia::render('Klinik/Edit', [
            'klinik' => $klinik
        ]);
    }

    public function update($id)
    {
        Request::validate([
            'namaKlinik' => ['required']
        ]);

        DB::update("update klinik set nama_klinik = :nama_klinik where id_klinik = :id_klinik", [
            'nama_klinik' => Request::input('namaKlinik'),
            'id_klinik' => $id
        ]);

        return Redirect::back()->with('success', 'Klinik berhasil diupdate.');
    }

    public function destroy($id)
    {
        DB::update("update klinik set deleted_at = :deleted_at where id_klinik = :id_klinik", [
            'deleted_at' => date("Y-m-d h:i:s"),
            'id_klinik' => $id
        ]);

        return Redirect::back()->with('success', 'Klinik berhasil dihapus.');
    }

    public function restore($id)
    {
        DB::update("update klinik set deleted_at = :deleted_at where id_klinik = :id_klinik", [
            'deleted_at' => null,
            'id_klinik' => $id
        ]);

        return Redirect::back()->with('success', 'Klinik berhasil dipulihkan.');
    }
}
