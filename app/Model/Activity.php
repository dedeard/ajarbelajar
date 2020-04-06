<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['post_id', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function post(){
        return $this->belongsTo(Post::class);
    }

    public static function createUserActivity(User $user, Post $post)
    {
        $q = $user->activities()->where('post_id', $post->id);
        if($q->exists()){
            $activity = $q->first();
            $activity->updated_at = now();
            $activity->save();
        } else {
            $user->activities()->save(new self(['post_id' => $post->id]));
            if($user->activities()->count() > 5) {
                $user->activities()->orderBy('updated_at', 'asc')->first()->delete();
            }
        }
    }
}
