<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class categoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'nameCategory' => 'Cuentos',
                'description' => 'Los libros de cuentos agrupan varios textos cortos a veces independientes a veces no, que giran entorno a un tema principal.',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nameCategory' => 'Cientificos',
                'description' => 'Los libros científicos cuentan procesos del cuerpo humano que no sabías. Descubre los entresijos de la química, la física o de la biología con los libros científicos de Leer para Pensar. Disfruta de libros de lectura fácil que te harán entender los procesos más primarios de la vida, el ser humano o del mundo. Leer para Pensar, tu blog de lectura sin publicidad.',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nameCategory' => 'Autobiograficos',
                'description' => 'Los libros autobiográficos cuentan historias increíbles de personajes famosos y anónimos, que por distintos motivos han tenido vidas increíbles.',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nameCategory' => 'Ciencia ficción',
                'description' => 'Los libros de ciencia ficción son obras de la literatura que construyen nuevos mundos, espacios, personajes y situaciones, ajenas y diferentes a nuestro mundo y nuestras vidas.',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nameCategory' => 'Aventuras',
                'description' => 'Los Libros de Aventuras narran historias increíbles de grandes personajes que han ido a la conquista de lo desconocido. ',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nameCategory' => 'Deporte',
                'description' => 'Los libros de deporte cuentan diferentes historias relacionadas con el deporte. ',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nameCategory' => 'Humor',
                'description' => 'Los Libros de humor te permiten pasar buenos momentos, reír y disfrutar de la lectura.',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nameCategory' => 'Salud',
                'description' => 'Los libros de salud nos ayudan a mantenernos en un buen estado físico y mental. ',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nameCategory' => 'Suspenso',
                'description' => 'Los libros de suspense cuentan historias que mantienen en vilo al espectador. Historias de miedo, historias que atrapan, historias que en definitiva consiguen absorber al lector en sus redes.',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],  
            [
                'nameCategory' => 'Videojuegos',
                'description' => 'Los libros de videojuegos muchas veces se publican por el aniversario del videojuego.',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nameCategory' => 'Sociedad',
                'description' => 'Libros sociedad son libros de actualidad y de la situación que vive actualmente el mundo.',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nameCategory' => 'Culto',
                'description' => 'Son libros que marcan una época, muchos de ellos se transforman en películas.',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        ]);
    }
}
