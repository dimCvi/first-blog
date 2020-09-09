<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password', 'phone', 'photo', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->surname;
    }

    public function deletePhoto() 
    {
        If (empty($this->photo)) {
            return $this;
        }

        $photoFilePath = public_path($this->photo);

        if (!is_file($photoFilePath)) {
            return $this;
        }
        
        unlink($photoFilePath);

        return $this;
    }
}
