<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Jelita',
            'username' => 'adminjelita',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        // Pegawai
        $pegawai = [
            ['name' => 'Ari Noviantari', 'username' => 'ari.noviantari', 'password' => 'Andreana1212#'],
            ['name' => 'Gde Susila', 'username' => 'gdesusila', 'password' => 'dua2tiga'],
            ['name' => 'Ria Nurul', 'username' => 'ria.nurul', 'password' => 'zachraria96'],
            ['name' => 'Nurul Hanifah S', 'username' => 'nurulhanifahs', 'password' => 'nina.nina456'],
            ['name' => 'M. Taufiq Qurrahman', 'username' => 'm.taufiqqurrahman', 'password' => 'QRMAN8395bps'],
            ['name' => 'I Nyoman Wahyu', 'username' => 'inyoman.wahyu', 'password' => '151096potter'],
            ['name' => 'Gde Ari Sudana', 'username' => 'gdeari.sudana', 'password' => 'boo4boy'],
            ['name' => 'I N. Pande', 'username' => 'in.pande', 'password' => 'Smanegeri1mengwi'],
            ['name' => 'Desak Pratiwi', 'username' => 'desak.pratiwi', 'password' => 'Astungkara26071995'],
            ['name' => 'Putu Minarni', 'username' => 'putu.minarni', 'password' => 'Minarni024##'],
            ['name' => 'Nonik Witana', 'username' => 'nonikwitana', 'password' => 'pen9new'],
            ['name' => 'Yan Putrawan', 'username' => 'Yanputrawan', 'password' => 'easy0july'],
            ['name' => 'Sunadi', 'username' => 'sunadi', 'password' => 'Satu3laku'],
            ['name' => 'I W. Widana', 'username' => 'iw.widana', 'password' => 'job3like'],
            ['name' => 'I D. P. Adnyana', 'username' => 'idp.adnyana', 'password' => 'susu2job'],
            ['name' => 'Surati', 'username' => 'surati', 'password' => 'apa2ada'],
            ['name' => 'Muliana', 'username' => 'muliana', 'password' => 'argade53'],
            ['name' => 'Bondiana P', 'username' => 'bondianap-pppk', 'password' => 'Naskeleng13'],
            ['name' => 'Ni Made Wilia', 'username' => 'nimadewilia-pppk', 'password' => 'Wilia22#'],
            ['name' => 'I Putu Edy', 'username' => 'iputuedy-pppk', 'password' => 'P3KEdy22#'],
            ['name' => 'I Made Subaga', 'username' => 'imadesubaga-pppk', 'password' => 'Subaga88'],
            ['name' => 'Zenda Oka', 'username' => 'zenda.oka', 'password' => 'zeen29'],
            ['name' => 'I Putu Agus', 'username' => 'iputuagus-pppk', 'password' => '@Aguz1812'],
            ['name' => 'I W. Kayun', 'username' => 'iw.kayun', 'password' => 'he8home'],
            ['name' => 'Geri Putri', 'username' => 'geriputri', 'password' => '9321Abee'],
            ['name' => 'Naufal Abdul', 'username' => 'naufal.abdul', 'password' => 'Naufal211810498'],
            ['name' => 'Gona Asri', 'username' => 'gona.asri', 'password' => 'Supertuna7'],
        ];

        foreach ($pegawai as $data) {
            User::create(array_merge($data, ['role' => 'pegawai']));
        }

        // Mitra
        $mitra = [
            ['name' => 'Mitra 01', 'username' => 'mitra01', 'password' => 'mitra123'],
            ['name' => 'Mitra 02', 'username' => 'mitra02', 'password' => 'mitra123'],
            ['name' => 'Mitra 03', 'username' => 'mitra03', 'password' => 'mitra123'],
            ['name' => 'Mitra 04', 'username' => 'mitra04', 'password' => 'mitra123'],
            ['name' => 'Mitra 05', 'username' => 'mitra05', 'password' => 'mitra123'],
        ];

        foreach ($mitra as $data) {
            User::create(array_merge($data, ['role' => 'mitra']));
        }
    }
}
