<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class NuxtController extends Controller
{
    public function home()
    {
        return [
            'popularPlaylists' => app(PlaylistsController::class)->popular(),
            'newPlaylists' => app(PlaylistsController::class)->news(),
            'newArticles' => app(ArticlesController::class)->news(),
            'popularCategories' => app(CategoriesController::class)->popular(),
            'mostUserPoints' => app(UsersController::class)->mostPoints()
        ];
    }
}
