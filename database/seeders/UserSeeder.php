<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'name' => 'Mervin Howard',
            'email' => 'mervinhoward@gmail.com',
            'password' => 'babura38',
            'role' => 'admin'
        ];
        User::create($user);
    }
}
