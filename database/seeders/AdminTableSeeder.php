<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'id'        => 1,
            'name'      => "Admin",
            'email'     => "Admin@lara.com",
            'password'  => Hash::make('p@ssw0rd'),
        ]);
    }
}
