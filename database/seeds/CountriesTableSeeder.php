<?php

use App\Country;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('Ru_RU');

        for ($i = 0; $i < 50; $i++) {
            $keys = $faker->words(10, false);

            Country::create([
                'title' => $faker->unique()->country(),
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
    }

}
