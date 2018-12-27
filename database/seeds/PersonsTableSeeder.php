<?php

use App\Person;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PersonsTableSeeder extends Seeder
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

        // Create 50 Person records
        $sex = [
            'Male',
            'Female',
        ];
        for ($i = 1; $i <= 50; $i++) {
            $one_or_null = $faker->numberBetween(0, 1);
            $name_function = 'firstName' . $sex[$one_or_null];
//            $lastname_function = 'lastName' . $sex[$one_or_null];
//            dd($name_function);
            if ($one_or_null == 1) {
                $lastname = $faker->lastname() . 'а';
            } else {
                $lastname = $faker->lastname();
            }

            Person::create([
                'firstname' => $faker->$name_function(),
                'lastname' => $lastname,
                'tall' => $faker->numberBetween(140, 205),
                'slug' => null,
                'birth_country' => $faker->numberBetween(1, 50),
                'birth_city' => $faker->numberBetween(1, 50),
                'published' => $one_or_null,
                'kp_id' => $faker->numberBetween(100000, 999999),
                'birth_date' => $faker->date('Y-m-d', 'now'),
            ]);
            
            $person = Person::findOrFail($i);
            $person->professions()->attach($faker->numberBetween(1, 10));
        }
    }

}
