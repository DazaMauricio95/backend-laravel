<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class booksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        DB::table('books')->insert([
            [
                'nameBook' => 'El monje que vendió su Ferrari',
                'author' => 'Robin Sharma',
                'publicationDate' => '2021-08-17',
                'Fkidcategory' => 1,
                'Fkidcreador' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                // '' => '',
                // '' => '',
            ],
            [
                'nameBook' => 'La vida secreta de la mente',
                'author' => 'Mariano Sigman',
                'publicationDate' => '2021-08-17',
                'Fkidcategory' => 2,
                'Fkidcreador' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                // '' => '',
                // '' => '',
            ],
            [
                'nameBook' => 'La enfermedad de escribir',
                'author' => 'Charles Bukowski',
                'publicationDate' => '2021-08-17',
                'Fkidcategory' => 3,
                'Fkidcreador' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                // '' => '',
                // '' => '',
            ],
            [
                'nameBook' => 'Dune',
                'author' => 'Frank Herbert',
                'publicationDate' => '2021-08-17',
                'Fkidcategory' => 4,
                'Fkidcreador' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                // '' => '',
                // '' => '',
            ]
        ]);
    }
}
