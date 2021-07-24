<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'avatar',
        'points',
        'about',
        'website',
        'username',
        'email',
        'password',
        'email_notification',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
