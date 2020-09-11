<?php

use Illuminate\Database\Seeder;
class PostCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_categories')->truncate();

        $postIds = DB::table('posts')->get()->pluck('id');
        
        $categoryIds = DB::table('categories')->get()->pluck('id');

        foreach ($postIds as $postId) {
            $randomCateogyIds = $categoryIds->random(5);
            foreach ($randomCateogyIds as $categoryId) {
                DB::table('post_categories')->insert([
                    'post_id' => $postId,
                    'category_id' => $categoryId,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
