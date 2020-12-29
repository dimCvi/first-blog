<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        DB::table('posts')->truncate();

        for ($i=1; $i <= 100; $i++) {
            DB::table('posts')->insert([
                'title' => $faker->city,
                'text' => $faker->realText(),
                'user_id' => User::first()->id,
                'featured' => $faker->boolean(),
                'status' => $faker->boolean(),
                'views' => $faker->randomFloat(0, 100, 10000),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
