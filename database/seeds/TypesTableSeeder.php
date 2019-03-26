<?php

use App\Type;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('Ru_RU');

        $types = [
            'Фильмы' => 'films',
            'Мультфильмы' => 'cartoons',
            'Сериалы' => 'serials',
            'ТВ' => 'tv',
        ];

        $i = 1;

        foreach ($types as $title => $slug) {
            $keys = $faker->words(10, false);
            
            Type::create([
                'title' => $title,
                'slug' => $slug,
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

            $type = Type::findOrFail($i);
            for ($k = 1; $k <= 10; $k++) {
                $type->genres()->attach($k);
            }
            $i++;
        }
    }

}
