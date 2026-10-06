<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    Role::create(['name'=>strtoupper('super-admin')]);
      Role::create(['name'=>strtoupper('admin')]);
      Role::create(['name'=>strtoupper('doctor')]);
      Role::create(['name'=>strtoupper('secretaria')]);
      Role::create(['name'=>strtoupper('paciente')]);
      // user
      User::create([
        'name'=>'Iver Balderrama Gira',
        'email'=>'admin@admin.com',
        'password'=>Hash::make('12345678'),
      ])->assignRole('SUPER-ADMIN');

      User::create([
        'name'=>'Danner Villca Gira',
        'email'=>'danner@admin.com',
        'password'=>Hash::make('12345678'),
      ]);
      User::create([
        'name'=>'yanira Villca Gira',
        'email'=>'yanira@admin.com',
        'password'=>Hash::make('12345678'),
      ]);
    }
}
