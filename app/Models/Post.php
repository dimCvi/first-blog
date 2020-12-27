<?php

namespace App\Models;

use App\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'status',
        'featured',
        'title',
        'text',
        'user_id',
        'views',
        'comments',
        'photo',
    ];

    public function author() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories() 
    {
        return $this->belongsToMany(
            Category::class,
            'post_categories',
            'post_id',
            'category_id'
        );
    }

    public function tags() 
    {
        return $this->belongsToMany(
            Tag::class,
            'post_tags',
            'post_id',
            'tag_id'
        );
    }
    
    public function deletePhoto()
    {
        if (empty($this->photo)) {
            return $this;
        }

        $photoFilePath = public_path($this->photo);

        if (! is_file($photoFilePath)) {
            return $this;
        }
        
        unlink($photoFilePath);

        return $this;
    }
}
