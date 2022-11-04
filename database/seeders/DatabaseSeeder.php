<?php

namespace Database\Seeders;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => bcrypt('admin12345'),
            'level' => 'admin',
            'remember_token' => Str::random(60),
    ]);
        // \App\Models\User::factory(10)->create();
    }
}
