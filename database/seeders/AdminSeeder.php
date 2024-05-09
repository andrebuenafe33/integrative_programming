<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'Andre',
            'middle_name' => 'Gloria',
            'last_name' => 'Buenafe',
            'address' => 'Brgy.Kangha-as',
            'phone' => '09107590281',
            'email' => 'Admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin231'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
