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

            $keys = $faker->words(10, false);

            Movie::create([
                'type_id' => $faker->numberBetween(1, 4),
                'title' => substr($faker->unique()->realText(10, 1), 0, -1),
                'title_en' => substr($faker_en->unique()->realText(10, 1), 0, -1),
                'slug' => null,
                'description' => $faker->realText(1000),
                'description_short' => $faker->realText(200),
                'kp_raiting' => $faker->numberBetween(60000, 99999),
                'imdb_raiting' => $faker->numberBetween(60000, 99999),
                'image' => $i,
                'image_show' => (boolean) 1,
                'iframe_url' => 'http://moonwalk.cc/video/63846be063ba298b/iframe',
                'meta_title' => substr($faker->unique()->realText(75, 5), 0, -1),
                'meta_description' => substr($faker->unique()->realText(175, 5), 0, -1),
                'meta_keywords' => implode(', ', $keys),
                'published' => (boolean) 1,
                'views' => $faker->numberBetween(100, 10000),
                'premiere' => $faker->dateTimeBetween('-10 years', 'now'),
                'duration' => $faker->numberBetween(90, 180),
                'kp_id' => $faker->unique()->numberBetween(100000, 999999),
                'created_by' => (integer) 1,
                'modified_by' => (integer) 1
            ]);

            $movie = Movie::findOrFail($i);
            $movie->update(['slug' => null]);
            $movie->countries()->attach($faker->numberBetween(1, 50));
            $movie->genres()->attach($faker->numberBetween(1, 10));
//            $movie->types()->attach($faker->numberBetween(1, 4));
        }
    }

}
