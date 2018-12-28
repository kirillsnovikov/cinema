<?php

use App\Person;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
            'Female',
            'Male',
        ];
        for ($i = 1; $i <= 50; $i++) {
            $one_or_null = $faker->numberBetween(0, 1);
            $name_function = 'firstName' . $sex[$one_or_null];
            $firstname = $faker->$name_function();
//            $lastname_function = 'lastName' . $sex[$one_or_null];
//            dd($name_function);
            if ($one_or_null == 1) {
                $lastname = $faker->lastname();
            } else {
                $lastname = $faker->lastname() . 'а';
            }

            Person::create([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'name_en' => Str::slug($firstname . ' ' . $lastname, ' '),
                'slug' => null,
                'sex' => $one_or_null,
                'tall' => $faker->numberBetween(160, 205),
                'birth_date' => $faker->date('Y-m-d', 'now'),
                'birth_country' => $faker->numberBetween(1, 50),
                'birth_city' => $faker->numberBetween(1, 50),
                'published' => $one_or_null,
                'kp_id' => $faker->numberBetween(100000, 999999),
                
            ]);

            $person = Person::findOrFail($i);
            $person->update(['slug' => null]);
            $person->professions()->attach($faker->numberBetween(1, 10));
        }
    }

}
