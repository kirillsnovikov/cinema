<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        for ($i = 0; $i < 50; $i++) {
//            DB::table('country_movie')->insert([
//            'country_id' => str_random(10),
//            'movie_id' => str_random(10).'@gmail.com',
//        ]);
//        }

        $this->call(PersonsTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(MoviesTableSeeder::class);
        $this->call(GenresTableSeeder::class);
        $this->call(TypesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
//        $this->call(ProfessionsTableSeeder::class);
    }

}
