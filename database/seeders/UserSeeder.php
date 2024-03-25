<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory(9)->create();

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin Smile Laundry',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '0813-8907-3557',
            'roles' => 'ADMIN',
            'address' => 'Jalan Inpres 4 RT 02 RW 06 Larangan Utara, RT.001/RW.006, Larangan Utara, Kec. Larangan, Kota Tangerang, Banten 15154',
            'note_address' => 'Seberang gang SMAN 12',
            'radius' => '1',
            'latitude_user' => '-6.23428056838952',
            'longitude_user' => '106.72582289599362',
        ]);
    }
}
