<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sitara.test'],
            [
                'name' => 'Admin REIMAKE',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'panitia@sitara.test'],
            [
                'name' => 'Panitia TPA',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
    }
}
