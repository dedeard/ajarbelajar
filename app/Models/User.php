<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

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


    /**
     * Atributes
     */
    public function getAvatarUrlAttribute()
    {
        if(!$this->avatar) {
            return 'https://ui-avatars.com/api/?bold=true&background=f0f2fc&color=677ae4&size=120&name=' . $this->name;
        }
        return AvatarHelper::getUrl($this->avatar);
    }
}
