<?php
use Illuminate\Database\Seeder;
use \Tok3\Publisher\Models\Domain as Domain;

class PublisherPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = \Faker\Factory::create('de_DE');
        $faker_en = \Faker\Factory::create();

        // domains/categories
        $domains = ['Health','Travel', 'Arts and Science', 'Real Estate'];
        foreach ($domains as $key => $name)
        {

            DB::table('tok3_publisher_domains')->insert([
                'slug' => str_slug($name),
                'name' => $name,
                'description' => $name . $faker->realText($maxNbChars = 15, $indexSize = 2),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }

        $domains = ['0' => 'No Domain'] + Domain::lists('name', 'id')->sort()->toArray();

        for ($i = 0; $i < 200; $i++)
        {

            $published_at = $faker->dateTimeBetween($startDate = '-2 years', $endDate = '+2 years');
            if ($published_at > \Carbon\Carbon::now())
            {

            }

            DB::table('tok3_publisher_pages')->insert([
                'slug' => $faker->slug(),
                'type' => rand(0,1),
                'title' => $faker->realText($maxNbChars = 30, $indexSize = 2),
                'heading' => $faker->realText($maxNbChars = 55, $indexSize = 2),
                'teaser' => $faker->realText($maxNbWords = 220, $indexSize = 2),
                'text' => $faker->realText($maxNbChars = 1000, $indexSize = 2),
                'published' => '1',
                'domain_id' => array_rand ($domains),
                'published_at' => $published_at,
                'meta_description' => $faker->realText($maxNbChars = 15, $indexSize = 2),
                'meta_keywords' => $faker->realText($maxNbChars = 15, $indexSize = 2),
                'add_head_data' => $faker->realText($maxNbChars = 14, $indexSize = 2),
                'og_descr' => $faker->realText($maxNbChars = 14, $indexSize = 2),
                'ip' => $faker->ipv6,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);


        }


        //
    }
}
