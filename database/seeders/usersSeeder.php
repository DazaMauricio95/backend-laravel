<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class usersSeeder extends Seeder
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
                'name'          => "Julian", 
                'lastname'      => "Vazquez", 
                "email"         => 'jualian@mail.com', 
                "password"      => Hash::make('1234'),
                "photo"         => "",
                "role"          => "admin",
                "active"        => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name'          => "Miguel", 
                'lastname'      => "Franco", 
                "email"         => '', 
                "password"      => "",
                "photo"         => "",
                "role"          => "user",
                "active"        => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name'          => "July", 
                'lastname'      => "Hernandez", 
                "email"         => '', 
                "password"      => "",
                "photo"         => "",
                "role"          => "user",
                "active"        => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        ]);
    }
}
