<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'username' => 'a@abc.org',
                'password' => Hash::make('Secret!')
            ],
            [
                'name' => 'user',
                'username' => 'b@abc.org',
                'password' => Hash::make('Secret!')
            ]
        ]);
    }
}
