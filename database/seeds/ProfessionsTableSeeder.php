<?php

use App\Profession;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProfessionsTableSeeder extends Seeder
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

        for ($i = 0; $i < 10; $i++) {
//            $one_or_null = $faker->numberBetween(0, 1);

            Profession::create([
                'title' => $faker->unique()->jobTitle(),
                'slug' => null,
                'published' => (integer)1,
            ]);
        }
    }
}
