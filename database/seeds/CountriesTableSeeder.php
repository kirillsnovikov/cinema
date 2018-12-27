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
        $faker_en = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            $one_or_null = $faker->numberBetween(0, 1);

            Country::create([
                'title' => $faker->unique()->country(),
                'slug' => null,
                'published' => $one_or_null,
            ]);
        }
    }

}
