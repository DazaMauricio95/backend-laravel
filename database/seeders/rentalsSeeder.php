<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class rentalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rentals')->insert([
            [
                "Fkidbook" => "1",  
                "Fkiduser" => "2",  
                "rentDate" => "2021-08-15",  
                "returnDate" => "2021-08-18",  
                "statusRent" => "0",  
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        ]);
    }
}
