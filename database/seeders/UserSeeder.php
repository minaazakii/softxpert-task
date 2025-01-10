<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mangerRole = Role::where('name', 'manager')->first();
        $userRole = Role::where('name', 'user')->first();

        $manager = User::updateOrCreate([
            'email' => 'manger@mail.com'
        ], [
            'name' => 'Manager',
            'email' => 'manger@mail.com',
            'password' => 'password',
            'email_verified_at' => now()
        ]);

        $user = User::updateOrCreate([
            'email' => 'user@mail.com'
        ], [
            'name' => 'User',
            'email' => 'user@mail.com',
            'password' => 'password',
            'email_verified_at' => now()
        ]);

        $manager->assignRole($mangerRole);
        $user->assignRole($userRole);
    }
}
