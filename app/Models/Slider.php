<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'slider';

    protected $fillable = [
        'status',
        'header',
        'photo',
        'url',
    ];

   
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
