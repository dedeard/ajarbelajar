<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notified extends Model
{
    protected $fillable = ['type', 'target_id'];
}
