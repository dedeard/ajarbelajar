<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
class PostView extends Model
{
    protected $fillable = [ 'session_id', 'ip', 'agent' ];

    public function viewable()
    {
        return $this->morphTo('viewable');
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
