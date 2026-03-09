<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['username' => 'ari.noviantari', 'password' => 'Andreana1212#'],
            ['username' => 'gdesusila', 'password' => 'dua2tiga'],
            ['username' => 'ria.nurul', 'password' => 'zachraria96'],
            ['username' => 'nurulhanifahs', 'password' => 'nina.nina456'],
            ['username' => 'm.taufiqqurrahman', 'password' => 'QRMAN8395bps'],
            ['username' => 'inyoman.wahyu', 'password' => '151096potter'],
            ['username' => 'gdeari.sudana', 'password' => 'boo4boy'],
            ['username' => 'in.pande', 'password' => 'Smanegeri1mengwi'],
            ['username' => 'desak.pratiwi', 'password' => 'Astungkara26071995'],
            ['username' => 'putu.minarni', 'password' => 'Minarni024##'],
            ['username' => 'nonikwitana', 'password' => 'pen9new'],
            ['username' => 'Yanputrawan', 'password' => 'easy0july'],
            ['username' => 'sunadi', 'password' => 'Satu3laku'],
            ['username' => 'iw.widana', 'password' => 'job3like'],
            ['username' => 'idp.adnyana', 'password' => 'susu2job'],
            ['username' => 'surati', 'password' => 'apa2ada'],
            ['username' => 'muliana', 'password' => 'argade53'],
            ['username' => 'bondianap-pppk', 'password' => 'Naskeleng13'],
            ['username' => 'nimadewilia-pppk', 'password' => 'Wilia22#'],
            ['username' => 'iputuedy-pppk', 'password' => 'P3KEdy22#'],
            ['username' => 'imadesubaga-pppk', 'password' => 'Subaga88'],
            ['username' => 'zenda.oka', 'password' => 'zeen29'],
            ['username' => 'iputuagus-pppk', 'password' => '@Aguz1812'],
            ['username' => 'iw.kayun', 'password' => 'he8home'],
            ['username' => 'geriputri', 'password' => '9321Abee'],
            ['username' => 'naufal.abdul', 'password' => 'Naufal211810498'],
            ['username' => 'gona.asri', 'password' => 'Supertuna7'],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['username'],
                'username' => $userData['username'],
                'password' => $userData['password'],
            ]);
        }
    }
}
