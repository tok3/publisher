<?php
namespace Tok3\Publisher;

use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    public function run()
    {


        $faker = \Faker\Factory::create('de_DE');
        $faker_en = \Faker\Factory::create();

        for ($i=0; $i < 25; $i++)
        {

            DB::table('tok3_demo_items')->insert([
                'slug' => 'test',
                'name' => 'Test',
                'description' => 'My first item test.',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

        }


        //
    }


}