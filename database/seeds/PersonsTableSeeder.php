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
//        $faker_en = Faker::create();
        // Create 50 Person records
        $sex = [
            'Female',
            'Male',
        ];
        for ($i = 1; $i <= 50; $i++) {
            $one_or_null = $faker->numberBetween(0, 1);
            $name_function = 'firstName' . $sex[$one_or_null];
            $firstname = $faker->$name_function();
            $keys = $faker->words(10, false);
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
                'description' => $faker->realText(1000),
                'description_short' => $faker->realText(200),
                'sex' => $one_or_null,
                'tall' => $faker->numberBetween(160, 205),
                'birth_date' => $faker->date('Y-m-d', '2000-01-01'),
                'birth_country' => $faker->numberBetween(1, 50),
                'birth_city' => $faker->numberBetween(1, 50),
                'image' => $i,
                'image_show' => (boolean) 1,
                'meta_title' => substr($faker->unique()->realText(75, 5), 0, -1),
                'meta_description' => substr($faker->unique()->realText(175, 5), 0, -1),
                'meta_keywords' => implode(', ', $keys),
                'published' => (boolean) 1,
                'views' => $faker->numberBetween(100, 10000),
                'kp_id' => $faker->numberBetween(100000, 999999),
                'created_by' => (integer) 1,
                'modified_by' => (integer) 1
            ]);

            $person = Person::findOrFail($i);
            $person->update(['slug' => null]);
//            $person->professions()->attach($faker->numberBetween(1, 10));

            $try = 0;
            $professions = [];

            while ($try < 5) {
                $num = $faker->numberBetween(1, 15);
                if (!in_array($num, $professions)) {
                    $professions[] = $num;
                    $try++;
                }
            }
            
            foreach ($professions as $profession) {
                $person->professions()->attach($profession);
            }
        }
    }

}
