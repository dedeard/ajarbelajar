<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Seo;
use Illuminate\Support\Facades\Cache;

class SeosController extends Controller
{
    public function index()
    {
        $data = Cache::remember('seo', 60 * 60 * 24, function () {
            return Seo::all();
        });

        return [
            'data' => $data
        ];
    }
}
