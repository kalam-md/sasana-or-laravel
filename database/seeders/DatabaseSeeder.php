<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'fullname' => 'Administrator',
            'username' => 'admin',
            'role' => 'admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin123')
        ]);

        User::create([
            'fullname' => 'Rudi Haryanto',
            'username' => 'rudi',
            'role' => 'user',
            'email' => 'rudi@mail.com',
            'password' => bcrypt('rudi123')
        ]);

        $times = [
            '06:00 - 07:00',
            '07:00 - 08:00',
            '08:00 - 09:00',
            '09:00 - 10:00',
            '10:00 - 11:00',
            '11:00 - 12:00',
            '12:00 - 13:00',
            '13:00 - 14:00',
            '14:00 - 15:00',
            '15:00 - 16:00',
            '16:00 - 17:00',
            '17:00 - 18:00',
            '18:00 - 19:00',
            '19:00 - 20:00',
            '20:00 - 21:00',
            '21:00 - 22:00',
            '22:00 - 23:00',
            '23:00 - 24:00',
        ];

        foreach ($times as $time) {
            Jadwal::create([
                'jam' => $time,
                'aktif' => 0,
            ]);
        }
    }
}
