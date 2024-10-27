<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123123123'),
            'cpf' => '82317564856',
            'birth_date' => '2000-01-01',
            'phone' => '11999999999',
            'sex' => 'feminine',
            'city' => 'Cidade',
            'state' => 'SP',
        ]);
        $user->assignRole('admin');
    }
}
