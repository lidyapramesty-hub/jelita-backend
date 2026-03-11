<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class MitraSeeder extends Seeder
{
    public function run(): void
    {
        $url = 'https://docs.google.com/spreadsheets/d/104RY1T6PdroozO7f71t2t701HHty0sWR/export?format=csv';

        try {
            $response = Http::withOptions(['allow_redirects' => true, 'verify' => false])->get($url);
            if (! $response->ok()) {
                $this->command->warn('Gagal mengambil data mitra dari Google Sheets.');
                return;
            }
            $csv = $response->body();
        } catch (\Exception $e) {
            $this->command->warn('Error: ' . $e->getMessage());
            return;
        }

        $rows = str_getcsv($csv, "\n");
        $created = 0;

        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // skip header

            $cols = str_getcsv($row);
            if (count($cols) < 3) continue;

            $name  = trim($cols[0]);
            $phone = trim($cols[1]);
            $pass  = trim($cols[2]);

            if (! $name || ! $phone || ! $pass) continue;

            // Normalize phone: remove leading 0 if present
            $phone = ltrim($phone, '0');

            // Skip if phone already exists
            if (User::where('phone', $phone)->exists()) continue;

            User::create([
                'name'     => $name,
                'username' => null,
                'phone'    => $phone,
                'password' => $pass,
                'role'     => 'mitra',
            ]);
            $created++;
        }

        $this->command->info("MitraSeeder: {$created} mitra berhasil dibuat.");
    }
}
