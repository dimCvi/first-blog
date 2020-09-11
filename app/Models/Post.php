<?php

namespace App\Models;

use App\User;
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

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
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
