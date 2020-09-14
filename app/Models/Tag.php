<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
        'name',
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
