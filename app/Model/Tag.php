<?php

namespace App\Model;

use Conner\Tagging\Model\Tag as ModelTag;

class Tag extends ModelTag
{
    public function taggeds()
    {
        // return $this->hasMany(Tagged::class, '');
    }
}