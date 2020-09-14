<?php

use Illuminate\Database\Seeder;

class SliderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        DB::table('slider')->truncate();

        for ($i=1; $i <= 10; $i++) {
            DB::table('slider')->insert([
                'header' => $faker->city,
                'status' => $faker->boolean(),
                'url' => $faker->url(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
