<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\models\Page;

class PagesController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('draf', false)->where('slug', $slug)->firstOrFail();
        return PageResource::make($page);
    }
}
