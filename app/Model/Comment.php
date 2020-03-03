<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Comment extends Model
{
    protected $fillable = [ 'body', 'user_id', 'approved' ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function can($str, $user) {
        if($str) {
            switch($str){
                case "edit":
                    if($this->user->id === $user->id) {
                        return true;
                    }
                break;
            }
        }
        return false;
    }
}
