<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PasienController extends Controller
{
    public function index()
    {
        $pasien = DB::table('pasien');

        if (!empty(Request::input("search"))) {
            $pasien->where('nama_pasien', 'like', '%' . Request::input("search") . '%');
        }

        if (!empty(Request::input("trashed"))) {
            if (Request::input("trashed") === "only") {
                $pasien->whereNotNull('deleted_at');
            }
        }

        return Inertia::render('Pasien/Index', [
            'filters' => Request::all('search', 'trashed'),
            'pasien' => [
                "data" => $pasien->get(),
                "links" => $pasien->paginate(15)
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Pasien/Create');
    }

    public function store()
    {
        Request::validate([
            'namaPasien' => ['required'],
            'alamatPasien' => ['required'],
            'noHp' => ['required']
        ]);

        DB::insert("insert into pasien (nama_pasien,alamat_pasien,no_hp) values (:nama_pasien, :alamat_pasien, :no_hp)", [
            'nama_pasien' => Request::input('namaPasien'),
            'alamat_pasien' => Request::input('alamatPasien'),
            'no_hp' => Request::input('noHp')
        ]);

        return Redirect::route('pasien')->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pasien = DB::select("select * from pasien where id_pasien = :id_pasien", [
            "id_pasien" => $id
        ])[0];

        return Inertia::render('Pasien/Edit', [
            'pasien' => $pasien
        ]);
    }

    public function update($id)
    {
        Request::validate([
            'namaPasien' => ['required'],
            'alamatPasien' => ['required'],
            'noHp' => ['required']
        ]);

        DB::update("update pasien set nama_pasien = :nama_pasien, alamat_pasien= :alamat_pasien ,no_hp = :no_hp where id_pasien = :id_pasien", [
            'nama_pasien' => Request::input('namaPasien'),
            'alamat_pasien' => Request::input('alamatPasien'),
            'no_hp' => Request::input('noHp'),
            'id_pasien' => $id
        ]);

        return Redirect::back()->with('success', 'Pasien berhasil diupdate.');
    }

    public function destroy($id)
    {
        DB::update("update pasien set deleted_at = :deleted_at where id_pasien = :id_pasien", [
            'deleted_at' => date("Y-m-d h:i:s"),
            'id_pasien' => $id
        ]);

        return Redirect::back()->with('success', 'Pasien berhasil dihapus.');
    }

    public function restore($id)
    {
        DB::update("update pasien set deleted_at = :deleted_at where id_pasien = :id_pasien", [
            'deleted_at' => null,
            'id_pasien' => $id
        ]);

        return Redirect::back()->with('success', 'Pasien berhasil dipulihkan.');
    }
}
