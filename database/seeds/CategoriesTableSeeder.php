<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        DB::table('categories')->truncate();

        for ($i=1; $i <= 10; $i++) {
            DB::table('categories')->insert([
                'header' => $faker->city,
                'description' => $faker->realText(),
                'priority' => $faker->boolean(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
