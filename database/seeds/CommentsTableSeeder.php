<?php

use App\Models\Post;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->truncate();
        $faker = \Faker\Factory::create();
        $posts = Post::get();
        foreach($posts as $post) {
            DB::table('comments')->insert([
                'post_id' => $post->id,
                'email' => $faker->email,
                'comment' => $faker->realText(),
                'status' => $faker->boolean(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
