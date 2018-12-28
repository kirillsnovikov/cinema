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
        $faker_en = Faker::create('En_EN');

        for ($i = 1; $i <= 150; $i++) {
//            $one_or_null = $faker->numberBetween(0, 1);
            $keys = $faker->words(10, false);

            Movie::create([
                'title' => substr($faker->unique()->realText(10, 1), 0, -1),
                'title_en' => substr($faker_en->unique()->realText(10, 5), 0, -1),
                'slug' => null,
                'description' => $faker->realText(1000),
                'description_short' => $faker->realText(200),
                'kp_raiting' => $faker->randomFloat(4, 6, 9),
                'imdb_raiting' => $faker->randomFloat(4, 6, 9),
                'image_name' => $i,
                'meta_title' => substr($faker->unique()->realText(75, 5), 0, -1),
                'meta_description' => substr($faker->unique()->realText(175, 5), 0, -1),
                'meta_keyword' => implode(', ', $keys),
                'published' => (integer)1,
                'views' => $faker->numberBetween(100, 10000),
                'year' => $faker->numberBetween(1970, 2018),
                'duration' => $faker->numberBetween(90, 180),
                'kp_id' => $faker->unique()->numberBetween(100000, 999999),
                'created_by' => (integer)1
            ]);
            
            $movie = Movie::findOrFail($i);
            $movie->update(['slug' => null]);
            $movie->countries()->attach($faker->numberBetween(1, 50));
            $movie->genres()->attach($faker->numberBetween(1, 10));
            
        }
    }

}
