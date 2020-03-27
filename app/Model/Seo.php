<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $fillable = [
        'name',
        'title',
        'description',
        'keywords',
        'robots',
        'distribution'
    ];

    public $timestamps = false;

    const PAGES = [
        'Home',
        'Article',
        'Video',
        'Category',
        'Minitutor',
        'Join Minitutor',

        'Auth Login',
        'Auth Register',
        'Auth Forget Password',
        'Auth Reset Password',
        'Auth Confirm Password',
        'Auth Verification',
    ];
}
