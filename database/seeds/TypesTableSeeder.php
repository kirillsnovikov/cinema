<?php

use App\Type;
//use Faker\Factory as Faker;
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
//        $faker = Faker::create('Ru_RU');
//        $faker_en = Faker::create();
        
        $types = [
            'Фильмы' => 'films',
            'Мультильмы' => 'cartoons',
            'Сериалы' => 'serials',
            'ТВ' => 'tv',
        ];
        
        $i = 1;

        foreach ($types as $title => $slug) {
            Type::create([
                'title' => $title,
                'slug' => $slug,
                'published' => (integer)1,
                'created_by' => (integer)1
            ]);
            
            $type = Type::findOrFail($i);
            for ($k = 1; $k <= 10; $k++) {
                $type->genres()->attach($k);
            }
            $i++;
        }
    }
}
