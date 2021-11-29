<?php

use Illuminate\Database\Seeder;
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
        \DB::table('users')->insert([
            [
                'email' => 'admin@admin.com',
                'name'  => 'Admin',
                'password' => Hash::make('password'),
                'type' => 'admin'
            ],
            [
                'email' => 'testMember01@gmail.com',
                'name'  => 'testMember01',
                'password' => Hash::make('password'),
                'type' => 'member'
            ],
            [
                'email' => 'testMember02@gmail.com',
                'name'  => 'testMember02',
                'password' => Hash::make('password'),
                'type' => 'member'
            ]
        ]);
    }
}
