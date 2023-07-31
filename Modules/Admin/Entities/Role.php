<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Database\factories\RoleFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'is_protected',
        'description',
    ];

    protected static function newFactory()
    {
        return RoleFactory::new();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function admins()
    {
        return $this->hasMany(Admin::class);
    }
}
