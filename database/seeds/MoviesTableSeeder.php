<?php

use App\Movie;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class MoviesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('Ru_RU');
        $faker_en = Faker::create();

        for ($i = 1; $i <= 150; $i++) {
//            $one_or_null = $faker->numberBetween(0, 1);

            Movie::create([
                'title' => $faker->unique()->word(),
                'description' => $faker->text(1000),
                'description_short' => $faker->text(1000),
                'slug' => null,
                'image_name' => $i,
                'published' => (integer)1,
                'kp_id' => $faker->numberBetween(100000, 999999),
            ]);
            
            $movie = Movie::findOrFail($i);
            $movie->countries()->attach($faker->numberBetween(1, 50));
            $movie->genres()->attach($faker->numberBetween(1, 10));
            
        }
    }

}
