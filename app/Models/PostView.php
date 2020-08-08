<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class PostView extends Model
{
    protected $fillable = [ 'post_id', 'session_id', 'ip', 'agent' ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public static function createViewLog($request)
    {
        return new self([
            'session_id' => $request->getSession()->getId() ?? '',
            'ip' => $request->getClientIp() ?? '',
            'agent' => $request->header('User-Agent') ?? ''
        ]);
    }
}
