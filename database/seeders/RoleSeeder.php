<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Default Guard
        // Role::create(['name' => 'admin']);
        // Role::create(['name' => 'writer']);
        // Role::create(['name' => 'user']);

        //Admin Guard
        Role::create(['name' => 'admin', 'guard_name' => 'admin']);
        Role::create(['name' => 'writer', 'guard_name' => 'admin']);
        Role::create(['name' => 'user', 'guard_name' => 'admin']);


    }
}
