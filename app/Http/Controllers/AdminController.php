<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        $admin = DB::table('admin');

        if (!empty(Request::input("search"))) {
            $admin->where('nama_admin', 'like', '%' . Request::input("search") . '%');
        }

        if (!empty(Request::input("trashed"))) {
            if (Request::input("trashed") === "only") {
                $admin->whereNotNull('deleted_at');
            }
        }

        return Inertia::render('Admin/Index', [
            'filters' => Request::all('search', 'trashed'),
            'admin' => [
                "data" => $admin->get(),
                "links" => $admin->paginate(15)
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Create');
    }

    public function store()
    {
        Request::validate([
            'namaAdmin' => ['required'],
            'username' => ['required'],
            'password' => ['required']
        ]);

        DB::insert("insert into admin (nama_admin, username, password) values (:nama_admin, :username, :password)", [
            'nama_admin' => Request::input('namaAdmin'),
            'username' => Request::input('username'),
            'password' => Hash::make(Request::input('password'))
        ]);

        return Redirect::route('admin')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $admin = DB::select("select * from admin where id_admin = :id_admin", [
            "id_admin" => $id
        ])[0];

        return Inertia::render('Admin/Edit', [
            'admin' => $admin
        ]);
    }

    public function update($id)
    {
        Request::validate([
            'namaAdmin' => ['required'],
            'username' => ['required'],
            'password' => ['required']
        ]);

        DB::update("update admin set nama_admin = :nama_admin, username = :username, password = :password where id_admin = :id_admin", [
            'nama_admin' => Request::input('namaAdmin'),
            'username' => Request::input('username'),
            'password' => Hash::make(Request::input('password')),
            'id_admin' => $id
        ]);

        return Redirect::back()->with('success', 'Admin berhasil diupdate.');
    }

    public function destroy($id)
    {
        DB::update("update admin set deleted_at = :deleted_at where id_admin = :id_admin", [
            'deleted_at' => date("Y-m-d h:i:s"),
            'id_admin' => $id
        ]);

        return Redirect::back()->with('success', 'Admin berhasil dihapus.');
    }

    public function restore($id)
    {
        DB::update("update admin set deleted_at = :deleted_at where id_admin = :id_admin", [
            'deleted_at' => null,
            'id_admin' => $id
        ]);

        return Redirect::back()->with('success', 'Admin berhasil dipulihkan.');
    }
}
