<?php

namespace App\Models;
use App\Models\Post;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    public function posts() {
        return $this->hasMany(
            Post::class,
            'post_categories',
            'id'
        );
    }

    protected $fillable = [
        'header',
        'description',
        'priority',
    ];
}
