<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use App\Imports\CityImport;
use App\Imports\VillageImport;
use App\Imports\DistrictImport;
use App\Imports\ProvinceImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin_role = Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $user_role = Role::create([
            'name' => 'user',
            'guard_name' => 'web'
        ]);

        $owner_role = Role::create([
            'name' => 'owner',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'dashboard_admin',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'dashboard_user',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'dashboard_owner',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'profile_admin',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'profile_user',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'profile_owner',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'notifications_admin',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'notifications_user',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'notifications_owner',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'ganti_password_admin',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'ganti_password_user',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'ganti_password_owner',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'users_admin',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'peraturan_admin',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'bank_admin',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'fasilitas_admin',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'provinsi_admin',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'kota_admin',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'kecamatan_admin',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'kelurahan_admin',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'berita_admin',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'roles_admin',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'permissions_admin',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'properti_admin',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'properti_user',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'properti_owner',
            'guard_name' => 'web'
        ]);

        $admin_role->givePermissionTo('dashboard_admin');
        $admin_role->givePermissionTo('dashboard_user');
        $admin_role->givePermissionTo('dashboard_owner');
        $admin_role->givePermissionTo('profile_admin');
        $admin_role->givePermissionTo('profile_user');
        $admin_role->givePermissionTo('profile_owner');
        $admin_role->givePermissionTo('ganti_password_admin');
        $admin_role->givePermissionTo('ganti_password_user');
        $admin_role->givePermissionTo('ganti_password_owner');
        $admin_role->givePermissionTo('notifications_admin');
        $admin_role->givePermissionTo('notifications_user');
        $admin_role->givePermissionTo('notifications_owner');
        $admin_role->givePermissionTo('users_admin');
        $admin_role->givePermissionTo('roles_admin');
        $admin_role->givePermissionTo('permissions_admin');
        $admin_role->givePermissionTo('peraturan_admin');
        $admin_role->givePermissionTo('bank_admin');
        $admin_role->givePermissionTo('fasilitas_admin');
        $admin_role->givePermissionTo('provinsi_admin');
        $admin_role->givePermissionTo('kota_admin');
        $admin_role->givePermissionTo('kecamatan_admin');
        $admin_role->givePermissionTo('kelurahan_admin');
        $admin_role->givePermissionTo('berita_admin');
        $admin_role->givePermissionTo('properti_admin');
        $admin_role->givePermissionTo('properti_owner');
        $admin_role->givePermissionTo('properti_user');

        $user_role->givePermissionTo('dashboard_user');
        $user_role->givePermissionTo('profile_user');
        $user_role->givePermissionTo('ganti_password_user');
        $user_role->givePermissionTo('notifications_user');
        $user_role->givePermissionTo('properti_user');

        $owner_role->givePermissionTo('dashboard_owner');
        $owner_role->givePermissionTo('profile_owner');
        $owner_role->givePermissionTo('ganti_password_owner');
        $owner_role->givePermissionTo('notifications_owner');
        $owner_role->givePermissionTo('properti_owner');

        $admin = User::create([
            'name' => 'Admin Account',
            'email' => 'admin@gmail.com',
            'phone_number' => '085171744592',
            'password' => Hash::make('admin123'),
        ]);
        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'User Account',
            'email' => 'user@gmail.com',
            'phone_number' => '081818607319',
            'password' => Hash::make('user123'),
        ]);
        $user->assignRole('user');

        $owner = User::create([
            'name' => 'Owner Account',
            'email' => 'owner@gmail.com',
            'phone_number' => '085183397739',
            'password' => Hash::make('owner123'),
        ]);
        $owner->assignRole('owner');

        $regulations = [
            ['id' => 1, 'name' => 'Lebih dari 5 orang / kamar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 2, 'name' => 'Ada jam malam', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 3, 'name' => 'Ada jam malam untuk tamu', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 4, 'name' => 'Akses 24 jam', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 5, 'name' => 'Bawa hasil test antigen', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 6, 'name' => 'Boleh bawa anak', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 7, 'name' => 'Boleh bawa hewan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 8, 'name' => 'Boleh pasutri', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 9, 'name' => 'Check-in pukul 14:00 - 21:00 (sewa harian)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 10, 'name' => 'Check-out maks. pukul 12:00 (sewa harian)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 11, 'name' => 'Denda kerusakan barang kos', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 12, 'name' => 'Dilarang bawa hewan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 13, 'name' => 'Dilarang menerima tamu', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 14, 'name' => 'Dilarang merokok dikamar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 15, 'name' => 'Harga termasuk listrik (sewa harian)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 16, 'name' => 'Kamar hanya bagi penyewa', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 17, 'name' => 'Khusus mahasiswa', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 18, 'name' => 'Khusus karyawan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 19, 'name' => 'Kriteria umum', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 20, 'name' => 'Lawan jenis dilarang masuk ke kamar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 21, 'name' => 'Maks. 1 orang / kamar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 22, 'name' => 'Maks. 2 orang / kamar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 23, 'name' => 'Maks. 3 orang / kamar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 24, 'name' => 'Maks. 4 orang / kamar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 25, 'name' => 'Maksimal 2 orang (sewa harian)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 26, 'name' => 'Menunjukan bukti swab saat check-in', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 27, 'name' => 'Pasutri wajib membawa surat nikah (sewa harian)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 28, 'name' => 'Termasuk listrik', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 29, 'name' => 'Tidak bisa DP (sewa harian)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 30, 'name' => 'Tidak boleh bawa anak', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 31, 'name' => 'Tidak untuk pasutri', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 32, 'name' => 'Wajib ikut piket', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 33, 'name' => 'Wajib lampirkan KTP saat check-in (sewa harian)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 34, 'name' => 'Wajib sertakan buku nikah saat pengajuan sewa', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 35, 'name' => 'Wajib sertakan kartu keluarga saat pengajuan sewa', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
        ];
        DB::table('regulations')->insert($regulations);

        $banks = [
            ['id' => 1, 'name' => 'Bank Central Asia (BCA)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 2, 'name' => 'Bank Mandiri', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 3, 'name' => 'Bank Rakyat Indonesia (BRI)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 4, 'name' => 'Bank Negara Indonesia (BNI)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 5, 'name' => 'Bank Tabungan Negara (BTN)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 6, 'name' => 'Bank Danamon', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 7, 'name' => 'Bank CIMB Niaga', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 8, 'name' => 'Bank Permata', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 9, 'name' => 'Bank Panin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 10, 'name' => 'Bank Mega', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 11, 'name' => 'Bank OCBC NISP', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 12, 'name' => 'Bank Maybank Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 13, 'name' => 'Bank HSBC Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 14, 'name' => 'Bank DBS Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 15, 'name' => 'Bank ANZ Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 16, 'name' => 'Bank UOB Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 17, 'name' => 'Bank Commonwealth', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 18, 'name' => 'Bank Bukopin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 19, 'name' => 'Bank BCA Syariah', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 20, 'name' => 'Bank BRI Syariah', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 21, 'name' => 'Bank BNI Syariah', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 22, 'name' => 'Bank Syariah Mandiri', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 23, 'name' => 'Bank Muamalat', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 24, 'name' => 'Bank Mega Syariah', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 25, 'name' => 'Bank BJB', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 26, 'name' => 'Bank BJB Syariah', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 27, 'name' => 'Bank Jatim', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 28, 'name' => 'Bank Jateng', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 29, 'name' => 'Bank Jabar Banten (BJB)', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 30, 'name' => 'Bank DKI', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 31, 'name' => 'Bank Sumut', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 32, 'name' => 'Bank Sultra', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 33, 'name' => 'Bank Nagari', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 34, 'name' => 'Bank Kalsel', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 35, 'name' => 'Bank Kalbar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 36, 'name' => 'Bank Kaltim', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 37, 'name' => 'Bank Kalteng', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 38, 'name' => 'Bank Sulselbar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 39, 'name' => 'Bank Sulteng', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 40, 'name' => 'Bank NTB', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 41, 'name' => 'Bank NTT', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 42, 'name' => 'Bank Maluku', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 43, 'name' => 'Bank Papua', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 44, 'name' => 'Bank Aceh', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 45, 'name' => 'Bank Bengkulu', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 46, 'name' => 'Bank Lampung', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 47, 'name' => 'Bank Banten', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 48, 'name' => 'Bank Sulut', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 49, 'name' => 'Bank Sulteng', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 50, 'name' => 'Bank Ina Perdana', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 51, 'name' => 'Bank Mestika Dharma', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 52, 'name' => 'Bank Sinarmas', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 53, 'name' => 'Bank Maspion', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 54, 'name' => 'Bank Ganesha', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 55, 'name' => 'Bank ICB Bumiputera', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 56, 'name' => 'Bank QNB Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 57, 'name' => 'Bank Woori Saudara', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 58, 'name' => 'Bank BTPN', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 59, 'name' => 'Bank BTPN Syariah', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 60, 'name' => 'Bank Mayapada', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 61, 'name' => 'Bank Artos', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 62, 'name' => 'Bank SBI Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 63, 'name' => 'Bank MNC', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 64, 'name' => 'Bank Bumi Arta', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 65, 'name' => 'Bank Hana', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 66, 'name' => 'Bank Mestika Dharma', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 67, 'name' => 'Bank Shinhan Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 68, 'name' => 'Bank Capital Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 69, 'name' => 'Bank BCA Digital', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 70, 'name' => 'Bank Neo Commerce', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 71, 'name' => 'Bank Seabank Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 72, 'name' => 'Bank Jago', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 73, 'name' => 'Bank Allo', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 74, 'name' => 'Bank Line', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 75, 'name' => 'Bank Nobu', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 76, 'name' => 'Bank Victoria International', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 77, 'name' => 'Bank China Construction Bank Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 78, 'name' => 'Bank Dinar Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 79, 'name' => 'Bank Jasa Jakarta', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 80, 'name' => 'Bank Kesejahteraan Ekonomi', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 81, 'name' => 'Bank Mayora', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 82, 'name' => 'Bank Index Selindo', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 83, 'name' => 'Bank Mutiara', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 84, 'name' => 'Bank Prima Master', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 85, 'name' => 'Bank Sahabat Sampoerna', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 86, 'name' => 'Bank Bisnis Internasional', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 87, 'name' => 'Bank Sri Partha', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 88, 'name' => 'Bank Victoria Syariah', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 89, 'name' => 'Bank Harda Internasional', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 90, 'name' => 'Bank Fama Internasional', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 91, 'name' => 'Bank Royal Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 92, 'name' => 'Bank Nationalnobu', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 93, 'name' => 'Bank Yudha Bhakti', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 94, 'name' => 'Bank Mitra Niaga', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 95, 'name' => 'Bank Agris', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 96, 'name' => 'Bank Sinar Harapan Bali', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 97, 'name' => 'Bank Bumi Arta', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 98, 'name' => 'Bank Himpunan Saudara 1906', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 99, 'name' => 'Bank Maspion Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 100, 'name' => 'Bank Agroniaga', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 101, 'name' => 'Bank IBK Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 102, 'name' => 'Bank Ekonomi Raharja', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 103, 'name' => 'Bank Antardaerah', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 104, 'name' => 'Bank Artha Graha Internasional', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 105, 'name' => 'Bank Pundi Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 106, 'name' => 'Bank Windu Kentjana International', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 107, 'name' => 'Bank Central Asia (BCA) Syariah', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 108, 'name' => 'Bank Multi Arta Sentosa', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 109, 'name' => 'Bank Rakyat Indonesia Agroniaga', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 110, 'name' => 'Bank Sahabat Purba Danarta', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 111, 'name' => 'Bank Bumi Arta', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 112, 'name' => 'Bank Mestika Dharma', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 113, 'name' => 'Bank Metro Express', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 114, 'name' => 'Bank Bintang Manunggal', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 115, 'name' => 'Bank Maspion', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 116, 'name' => 'Bank Hana', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 117, 'name' => 'Bank INA', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 118, 'name' => 'Bank Bisnis Internasional', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 119, 'name' => 'Bank Jasa Jakarta', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 120, 'name' => 'Bank Kesejahteraan Ekonomi', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 121, 'name' => 'Bank Artos Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 122, 'name' => 'Bank Purba Danarta', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 123, 'name' => 'Bank Multi Arta Sentosa', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 124, 'name' => 'Bank Mayora Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 125, 'name' => 'Bank Index Selindo', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 126, 'name' => 'Bank Victoria International', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 127, 'name' => 'Bank Harda Internasional', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 128, 'name' => 'Bank Fama Internasional', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 129, 'name' => 'Bank Mutiara', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 130, 'name' => 'Bank Royal Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 131, 'name' => 'Bank Nationalnobu', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 132, 'name' => 'Bank Yudha Bhakti', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 133, 'name' => 'Bank Mitra Niaga', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 134, 'name' => 'Bank Agris', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 135, 'name' => 'Bank Sinar Harapan Bali', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 136, 'name' => 'Bank Himpunan Saudara 1906', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 137, 'name' => 'Bank Maspion Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 138, 'name' => 'Bank IBK Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 139, 'name' => 'Bank Ekonomi Raharja', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 140, 'name' => 'Bank Antardaerah', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 141, 'name' => 'Bank Artha Graha Internasional', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 142, 'name' => 'Bank Pundi Indonesia', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 143, 'name' => 'Bank Windu Kentjana International', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 144, 'name' => 'Bank Multi Arta Sentosa', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 145, 'name' => 'Bank Sahabat Purba Danarta', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 146, 'name' => 'Bank Bintang Manunggal', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 147, 'name' => 'Bank Maspion', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 148, 'name' => 'Bank Hana', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 149, 'name' => 'Bank INA', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 150, 'name' => 'Bank Jasa Jakarta', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
        ];
        DB::table('banks')->insert($banks);

        $facilities = [
            ['id' => 1, 'name' => 'Balcon', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 2, 'name' => 'CCTV', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 3, 'name' => 'Dapur', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 4, 'name' => 'Dispenser', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 5, 'name' => 'Duplikat Gerbang Kos', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 6, 'name' => 'Gazebo', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 7, 'name' => 'Jemuran', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 8, 'name' => 'Joglo', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 9, 'name' => 'Jual Makanan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 10, 'name' => 'Kamar Mandi Luar', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 11, 'name' => 'Kamar Mandi Luar - WC Duduk', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 12, 'name' => 'Kamar Mandi Luar - WC Jongkok', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 13, 'name' => 'Kartu Akses', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 14, 'name' => 'Kompor', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 15, 'name' => 'Kulkas', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 16, 'name' => 'Laundry', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 17, 'name' => 'Locker', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 18, 'name' => 'Mesin Cuci', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 19, 'name' => 'Mushola', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 20, 'name' => 'Pengurus Kos', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 21, 'name' => 'Penjaga Kos', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 22, 'name' => 'Ruang Cuci', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 23, 'name' => 'Ruang Jemur', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 24, 'name' => 'Ruang Keluarga', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 25, 'name' => 'Ruang Makan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 26, 'name' => 'Ruang Santai', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 27, 'name' => 'Ruang Tamu', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 28, 'name' => 'Rice Cooker', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 29, 'name' => 'Rooftop', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 30, 'name' => 'TV', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 31, 'name' => 'Taman', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 32, 'name' => 'WiFi', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 33, 'name' => 'AC', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 34, 'name' => 'Bantal', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 35, 'name' => 'Cermin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 36, 'name' => 'Cleaning Service', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 37, 'name' => 'Dapur Pribadi', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 38, 'name' => 'Guling', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 39, 'name' => 'Jendela', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 40, 'name' => 'Kasur', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 41, 'name' => 'Keset Toilet', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 42, 'name' => 'Kipas Angin', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 43, 'name' => 'Kulkas', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 44, 'name' => 'Kursi', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 45, 'name' => 'Lemari baju', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 46, 'name' => 'Meja', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 47, 'name' => 'Meja Rias', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 48, 'name' => 'Meja Makan', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 49, 'name' => 'Sofa', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 50, 'name' => 'Ventilasi', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 51, 'name' => 'Wastafel', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 52, 'name' => 'Water Heater', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 53, 'name' => 'Microwave', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 54, 'name' => 'Air Panas', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 55, 'name' => 'Bak Mandi', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 56, 'name' => 'Bathup', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 57, 'name' => 'Ember Mandi', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 58, 'name' => 'Kamar Mandi Dalam', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 59, 'name' => 'Kloset Jongkok', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 60, 'name' => 'Shower', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 61, 'name' => 'Parkir Mobil', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 62, 'name' => 'Parkir Motor', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
            ['id' => 63, 'name' => 'Parkir Sepeda', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'created_by' => 1],
        ];
        DB::table('facilities')->insert($facilities);

        News::create([
            'date' => date('Y-m-d'),
            'title' => 'Berita 1',
            'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi provident sed, corporis amet sint ratione tenetur rerum non repudiandae. Voluptatibus pariatur facere voluptate neque aliquid doloribus corrupti natus. Blanditiis dolore, saepe debitis autem enim molestias? Neque dicta officia officiis ut sit! Iste dolor excepturi atque quidem ipsum quam dignissimos eum neque rem. Assumenda saepe eligendi amet? Iste earum soluta deleniti facilis odio! Temporibus ut veniam minima modi voluptatibus, consequatur quidem voluptates provident ratione eaque totam similique et in perferendis molestiae incidunt aut voluptatem ad, quisquam praesentium ex beatae, fugit aperiam. Quos sit ad est aspernatur in eum accusamus, asperiores voluptatum.',
            'news_file_path' => 'news_file_path/banner.jpg',
            'created_by' => 1
        ]);

        News::create([
            'date' => date('Y-m-').date('d', strtotime('+1 day')),
            'title' => 'Berita 2',
            'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi provident sed, corporis amet sint ratione tenetur rerum non repudiandae. Voluptatibus pariatur facere voluptate neque aliquid doloribus corrupti natus. Blanditiis dolore, saepe debitis autem enim molestias? Neque dicta officia officiis ut sit! Iste dolor excepturi atque quidem ipsum quam dignissimos eum neque rem. Assumenda saepe eligendi amet? Iste earum soluta deleniti facilis odio! Temporibus ut veniam minima modi voluptatibus, consequatur quidem voluptates provident ratione eaque totam similique et in perferendis molestiae incidunt aut voluptatem ad, quisquam praesentium ex beatae, fugit aperiam. Quos sit ad est aspernatur in eum accusamus, asperiores voluptatum.',
            'news_file_path' => 'news_file_path/banner2.jpg',
            'created_by' => 1
        ]);

        News::create([
            'date' => date('Y-m-').date('d', strtotime('+2 day')),
            'title' => 'Berita 3',
            'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi provident sed, corporis amet sint ratione tenetur rerum non repudiandae. Voluptatibus pariatur facere voluptate neque aliquid doloribus corrupti natus. Blanditiis dolore, saepe debitis autem enim molestias? Neque dicta officia officiis ut sit! Iste dolor excepturi atque quidem ipsum quam dignissimos eum neque rem. Assumenda saepe eligendi amet? Iste earum soluta deleniti facilis odio! Temporibus ut veniam minima modi voluptatibus, consequatur quidem voluptates provident ratione eaque totam similique et in perferendis molestiae incidunt aut voluptatem ad, quisquam praesentium ex beatae, fugit aperiam. Quos sit ad est aspernatur in eum accusamus, asperiores voluptatum.',
            'news_file_path' => 'news_file_path/banner3.jpg',
            'created_by' => 1
        ]);

        News::create([
            'date' => date('Y-m-').date('d', strtotime('+3 day')),
            'title' => 'Berita 4',
            'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi provident sed, corporis amet sint ratione tenetur rerum non repudiandae. Voluptatibus pariatur facere voluptate neque aliquid doloribus corrupti natus. Blanditiis dolore, saepe debitis autem enim molestias? Neque dicta officia officiis ut sit! Iste dolor excepturi atque quidem ipsum quam dignissimos eum neque rem. Assumenda saepe eligendi amet? Iste earum soluta deleniti facilis odio! Temporibus ut veniam minima modi voluptatibus, consequatur quidem voluptates provident ratione eaque totam similique et in perferendis molestiae incidunt aut voluptatem ad, quisquam praesentium ex beatae, fugit aperiam. Quos sit ad est aspernatur in eum accusamus, asperiores voluptatum.',
            'news_file_path' => 'news_file_path/banner4.jpg',
            'created_by' => 1
        ]);

        News::create([
            'date' => date('Y-m-').date('d', strtotime('+4 day')),
            'title' => 'Berita 5',
            'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi provident sed, corporis amet sint ratione tenetur rerum non repudiandae. Voluptatibus pariatur facere voluptate neque aliquid doloribus corrupti natus. Blanditiis dolore, saepe debitis autem enim molestias? Neque dicta officia officiis ut sit! Iste dolor excepturi atque quidem ipsum quam dignissimos eum neque rem. Assumenda saepe eligendi amet? Iste earum soluta deleniti facilis odio! Temporibus ut veniam minima modi voluptatibus, consequatur quidem voluptates provident ratione eaque totam similique et in perferendis molestiae incidunt aut voluptatem ad, quisquam praesentium ex beatae, fugit aperiam. Quos sit ad est aspernatur in eum accusamus, asperiores voluptatum.',
            'news_file_path' => 'news_file_path/banner5.jpg',
            'created_by' => 1
        ]);

        Excel::import(new ProvinceImport, public_path('province.xlsx'));
        Excel::import(new CityImport, public_path('city.xlsx'));
        Excel::import(new DistrictImport, public_path('district.xlsx'));
        Excel::import(new VillageImport, public_path('village.xlsx'));
    }
}
