<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Helpers\Seo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        Seo::set('Dashboard Review');
        $data = [];
        $reviews = $request->user()->postReviews()->select(['*'])->with(['post' => function($q){
            $q->select(['id', 'title', 'slug', 'created_at', 'updated_at']);
        }, 'user' => function($q){
            $q->select('*');
        }]);
        $rating = $request->query('rating');
        if($rating && $rating >= 1 && $rating <= 5){
            $reviews->where('rating', $rating);
        }
        $data['reviews'] = $reviews->orderBy('post_reviews.created_at', 'desc')->paginate(15);
        return view('web.dashboard.review.index', $data);
    }
}
