<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Database\factories\PermissionFactory;

class Permission extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    protected static function newFactory()
    {
        return PermissionFactory::new();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
