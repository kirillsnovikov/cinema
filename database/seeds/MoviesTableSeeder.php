<?php

use App\Movie;
use App\Person;
use App\Profession;
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

        for ($i = 1; $i <=150; $i++) {

            $keys = $faker->words(10, false);

            $movie = Movie::create([
                        'title' => substr($faker->unique()->realText(10, 1), 0, -1),
                        'title_en' => substr($faker_en->unique()->realText(10, 1), 0, -1),
                        'type_id' => $faker->numberBetween(1, 4),
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

            $movie->update(['slug' => null]);
            $movie->countries()->attach($faker->numberBetween(1, 50));
            $director = $faker->numberBetween(10, 30);
            $movie->directors()->attach($director);

            if (!Profession::where('title', 'Директор')->first()) {
                Profession::create([
                    'title' => 'Директор',
                    'slug' => null,
                    'description' => $faker->realText(1000),
                    'image' => $i,
                    'image_show' => (boolean) 1,
                    'meta_title' => substr($faker->unique()->realText(75, 5), 0, -1),
                    'meta_description' => substr($faker->unique()->realText(175, 5), 0, -1),
                    'meta_keywords' => implode(', ', $keys),
                    'published' => (boolean) 1,
                    'created_by' => (integer) 1,
                    'modified_by' => (integer) 1
                ]);
            }

            $profession_director = Profession::where('title', 'Директор')->first();
            $person_director = Person::findOrFail($director);
            $person_profession = $person_director->professions()->where('title', 'Директор')->first();

            /* @var $person_profession type */
            if (!$person_profession) {
                $person_director->professions()->attach($profession_director->id);
            }


            $genres = [];
            $actors = [];
            $k = 0;
            $j = 0;

            while ($k < 3) {
                $genre = $faker->numberBetween(1, 10);
                if (!in_array($genre, $genres)) {
                    $genres[] = $genre;
                    $k++;
                }
            }

            while ($j < 7) {
                $actor = $faker->numberBetween(1, 50);
                if (!in_array($actor, $actors)) {
                    $actors[] = $actor;
                    $j++;
                }
            }

            $movie->genres()->attach($genres);
            $movie->actors()->attach($actors);

            foreach ($actors as $actor) {
                if (!Profession::where('title', 'Актер')->first()) {
                    Profession::create([
                        'title' => 'Актер',
                        'slug' => null,
                        'description' => $faker->realText(1000),
                        'image' => $i,
                        'image_show' => (boolean) 1,
                        'meta_title' => substr($faker->unique()->realText(75, 5), 0, -1),
                        'meta_description' => substr($faker->unique()->realText(175, 5), 0, -1),
                        'meta_keywords' => implode(', ', $keys),
                        'published' => (boolean) 1,
                        'created_by' => (integer) 1,
                        'modified_by' => (integer) 1
                    ]);
                }

                $profession = Profession::where('title', 'Актер')->first();
                $person = Person::findOrFail($actor);
                $person_profession = $person->professions()->where('title', 'Актер')->first();

                /* @var $person_profession type */
                if (!$person_profession) {
                    $person->professions()->attach($profession->id);
                }
//                    foreach ($person_professions as $person_profession) {
//                        if ($person_profession->title != 'Актер') {
//                            $person->professions()->attach($profession->id);
//                        }
//                    }
//                dd();
//                $profession = Profession::firstOrCreate([
//                            'title' => 'Актер',
//                            'slug' => null,
//                            'description' => $faker->realText(1000),
//                            'image' => $i,
//                            'image_show' => (boolean) 1,
//                            'meta_title' => substr($faker->unique()->realText(75, 5), 0, -1),
//                            'meta_description' => substr($faker->unique()->realText(175, 5), 0, -1),
//                            'meta_keywords' => implode(', ', $keys),
//                            'published' => (boolean) 1,
//                            'created_by' => (integer) 1,
//                            'modified_by' => (integer) 1
//                ]);
            }
        }
    }

}
