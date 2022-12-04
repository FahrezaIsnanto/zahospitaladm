<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Admin;
use App\Models\Contact;
use App\Models\Dokter;
use App\Models\Klinik;
use App\Models\Organization;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::factory()->create();

        $pasien = Pasien::factory()->create();

        $klinik = Klinik::create([
            'nama_klinik' => 'mata'
        ]);

        $dokter = Dokter::factory()->create();

        Pendaftaran::create([
            'id_pasien' => $pasien->id_pasien,
            'id_klinik' => $klinik->id_klinik,
            'id_dokter' => $dokter->id_dokter,
            'dicatat_oleh' => $admin->id_admin,
            'tanggal_periksa' => date("Y-m-d"),
            'no_antrian' => 1
        ]);
    }
}
