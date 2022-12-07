<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;


class PendaftaranController extends Controller
{
    public function index()
    {
        $pendaftaran = DB::table('pendaftaran')
            ->selectRaw("
                pendaftaran.id_pendaftaran,
                pasien.nama_pasien as pasien,
                klinik.nama_klinik as klinik,
                dokter.nama_dokter as dokter,
                DATE_FORMAT(pendaftaran.tanggal_periksa,'%d-%m-%Y') as tanggal_periksa,
                admin.nama_admin as dicatat_oleh,
                pendaftaran.no_antrian,
                pendaftaran.deleted_at
                ")
            ->leftJoin('pasien', 'pendaftaran.id_pasien', 'pasien.id_pasien')
            ->leftJoin('klinik', 'pendaftaran.id_klinik', 'klinik.id_klinik')
            ->leftJoin('dokter', 'pendaftaran.id_dokter', 'dokter.id_dokter')
            ->leftJoin('admin', 'pendaftaran.dicatat_oleh', 'admin.id_admin');

        if (!empty(Request::input("search"))) {
            $pendaftaran->where('pasien.nama_pasien', 'like', '%' . Request::input("search") . '%');
            $pendaftaran->orWhere('klinik.nama_klinik',  'like', '%' . Request::input("search") . '%');
            $pendaftaran->orWhere('dokter.nama_dokter',  'like', '%' . Request::input("search") . '%');
        }

        if (!empty(Request::input("trashed"))) {
            if (Request::input("trashed") === "only") {
                $pendaftaran->whereNotNull('pendaftaran.deleted_at');
            }
        }

        return Inertia::render('Pendaftaran/Index', [
            'filters' => Request::all('search', 'trashed'),
            'pendaftaran' => [
                "data" => $pendaftaran->get(),
                "links" => $pendaftaran->paginate(15)
            ]
        ]);
    }

    public function create()
    {
        $pasienOpsi = DB::select("select * from pasien");
        $klinikOpsi = DB::select("select * from klinik");
        $dokterOpsi = DB::select("select * from dokter");

        return Inertia::render(
            'Pendaftaran/Create',
            [
                "pasienOpsi" => $pasienOpsi,
                "klinikOpsi" => $klinikOpsi,
                "dokterOpsi" => $dokterOpsi,
            ]
        );
    }

    public function store()
    {
        Request::validate([
            'tanggalPeriksa' => ['required'],
            'pasien'    => ['required'],
            'klinik'    => ['required'],
            'dokter'    => ['required'],
        ]);

        $tanggalPeriksa = convertDateToSQL(Request::input('tanggalPeriksa'));
        $pasien = Request::input('pasien');
        $klinik = Request::input('klinik');
        $dokter = Request::input('dokter');
        $dicatat_oleh = Request::session()->get('admin')->id_admin;


        /* check if pendaftaran by pasien exist */
        $pendaftaranExist = DB::select("select * from pendaftaran where tanggal_periksa = :tanggal_periksa and id_pasien = :id_pasien and id_klinik = :id_klinik and id_dokter = :id_dokter", [
            "tanggal_periksa" => $tanggalPeriksa,
            "id_pasien" => $pasien,
            "id_klinik" => $klinik,
            "id_dokter" => $dokter
        ]);

        if ($pendaftaranExist) {
            return Redirect::back()->with('error', 'Pasien sudah melakukan pendaftaran sesuai dengan data yang dimasukkan!');
        }

        /* get no antrian by klinik and dokter */
        $noAntrian = DB::select("select count(*) as qty from pendaftaran where tanggal_periksa = :tanggal_periksa and id_klinik = :id_klinik and id_dokter = :id_dokter", [
            "tanggal_periksa" => $tanggalPeriksa,
            "id_klinik" => $klinik,
            "id_dokter" => $dokter
        ])[0]->qty + 1;


        DB::insert("insert into pendaftaran (tanggal_periksa, id_pasien,id_klinik,id_dokter,dicatat_oleh,no_antrian) 
                    values (:tanggal_periksa, :id_pasien, :id_klinik, :id_dokter, :dicatat_oleh, :no_antrian )", [
            'tanggal_periksa' => $tanggalPeriksa,
            'id_pasien' => $pasien,
            'id_klinik' => $klinik,
            'id_dokter' => $dokter,
            'dicatat_oleh' => $dicatat_oleh,
            "no_antrian" => $noAntrian
        ]);

        return Redirect::route('pendaftaran')->with('success', 'Pendaftaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pendaftaran = DB::select(
            "select 
                id_pendaftaran, 
                DATE_FORMAT(pendaftaran.tanggal_periksa,'%d-%m-%Y') as tanggal_periksa,
                id_pasien,
                id_klinik,
                id_dokter,
                deleted_at
            from pendaftaran where id_pendaftaran = :id_pendaftaran",
            [
                "id_pendaftaran" => $id
            ]
        )[0];

        $pasienOpsi = DB::select("select * from pasien");
        $klinikOpsi = DB::select("select * from klinik");
        $dokterOpsi = DB::select("select * from dokter");

        return Inertia::render('Pendaftaran/Edit', [
            'pendaftaran' => $pendaftaran,
            "pasienOpsi" => $pasienOpsi,
            "klinikOpsi" => $klinikOpsi,
            "dokterOpsi" => $dokterOpsi,
        ]);
    }

    public function update($id)
    {
        Request::validate([
            'tanggalPeriksa' => ['required'],
            'pasien'    => ['required'],
            'klinik'    => ['required'],
            'dokter'    => ['required'],
        ]);

        $tanggalPeriksa = convertDateToSQL(Request::input('tanggalPeriksa'));
        $pasien = Request::input('pasien');
        $klinik = Request::input('klinik');
        $dokter = Request::input('dokter');
        $dicatat_oleh = Request::session()->get('admin')->id_admin;


        /* check if pendaftaran by pasien exist */
        $pendaftaranExist = DB::select("select * from pendaftaran where tanggal_periksa = :tanggal_periksa and id_pasien = :id_pasien and id_klinik = :id_klinik and id_dokter = :id_dokter", [
            "tanggal_periksa" => $tanggalPeriksa,
            "id_pasien" => $pasien,
            "id_klinik" => $klinik,
            "id_dokter" => $dokter
        ]);

        if ($pendaftaranExist) {
            return Redirect::back()->with('error', 'Pasien tidak melakukan update pendaftaran apapun!');
        }

        /* get no antrian by klinik and dokter */
        $noAntrian = DB::select("select count(*) as qty from pendaftaran where tanggal_periksa = :tanggal_periksa and id_klinik = :id_klinik and id_dokter = :id_dokter", [
            "tanggal_periksa" => $tanggalPeriksa,
            "id_klinik" => $klinik,
            "id_dokter" => $dokter
        ])[0]->qty + 1;


        DB::update(
            "update pendaftaran set tanggal_periksa = :tanggal_periksa, id_pasien = :id_pasien, id_klinik = :id_klinik, id_dokter = :id_dokter, dicatat_oleh = :dicatat_oleh, no_antrian = :no_antrian where id_pendaftaran = :id_pendaftaran",
            [
                'tanggal_periksa' => $tanggalPeriksa,
                'id_pasien' => $pasien,
                'id_klinik' => $klinik,
                'id_dokter' => $dokter,
                'dicatat_oleh' => $dicatat_oleh,
                "no_antrian" => $noAntrian,
                "id_pendaftaran" => $id
            ]
        );

        return Redirect::back()->with('success', 'Pendaftaran berhasil diupdate.');
    }

    public function destroy($id)
    {
        DB::update("update pendaftaran set deleted_at = :deleted_at where id_pendaftaran = :id_pendaftaran", [
            'deleted_at' => date("Y-m-d h:i:s"),
            'id_pendaftaran' => $id
        ]);

        return Redirect::back()->with('success', 'Pendaftaran berhasil dihapus.');
    }

    public function restore($id)
    {
        DB::update("update pendaftaran set deleted_at = :deleted_at where id_pendaftaran = :id_pendaftaran", [
            'deleted_at' => null,
            'id_pendaftaran' => $id
        ]);

        return Redirect::back()->with('success', 'Pendaftaran berhasil dipulihkan.');
    }
}
