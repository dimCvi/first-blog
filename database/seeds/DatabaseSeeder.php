<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(PostCategoriesSeeder::class);
        $this->call(SliderTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(PostTagsSeeder::class);
        $this->call(CommentsTableSeeder::class);
    }
}
