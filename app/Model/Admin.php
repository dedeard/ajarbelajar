<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = ['user_id'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
