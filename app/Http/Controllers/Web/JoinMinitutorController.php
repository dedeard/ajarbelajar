<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Seo;
use App\Http\Controllers\Controller;
use App\Model\Minitutor;
use App\Model\Post;
use App\Model\RequestMinitutor;
use App\Model\User;
use Illuminate\Http\Request;

class JoinMinitutorController extends Controller
{
    const EDUCATIONS = [ 'D1', 'D2', 'D3', 'S1', 'S2', 'S3' ];

    public function index()
    {
        Seo::set('Join Minitutor');
        $data = [
            'user_count' => User::count(),
            'minitutor_count' => Minitutor::count(),
            'post_count' => Post::where('draf', 0)->count()
        ];
        return view('web.joinMinitutor.index', $data);
    }

    public function create(Request $request)
    {
        $user = $request->user();
        if($user->requestMinitutor) {
            return redirect()->route('join.minitutor.edit');
        }
        return view('web.joinMinitutor.create', ['last_educations' => self::EDUCATIONS]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'last_education' => 'required|string|max:50',
            'university' => 'required|string|max:250',
            'city_and_country_of_study' => 'required|string|max:250',
            'majors' => 'required|string|max:250',
            'interest_talent' => 'required|string|max:250',
            'contact' => 'required|string|max:250',
            'reason' => 'required|string|max:250',
            'expectation' => 'required|string|max:250'
        ]);

        if ($user->requestMinitutor){
            $user->requestMinitutor()->update($data);
        } else {
            $requestMinitutor = new RequestMinitutor($data);
            $user->requestMinitutor()->save($requestMinitutor);
        }

        return redirect()->route('join.minitutor.edit')->withSuccess('Permintaan anda untuk menjadi Minitutor telah dibuat. Silahkan tunngu notifikasi selenjutnta');
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        if(!$user->requestMinitutor) {
            return redirect()->route('join.minitutor.create');
        }
        return view('web.joinMinitutor.edit', ['last_educations' => self::EDUCATIONS, 'request_minitutor' => $user->requestMinitutor]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'last_education' => 'required|string|max:50',
            'university' => 'required|string|max:250',
            'city_and_country_of_study' => 'required|string|max:250',
            'majors' => 'required|string|max:250',
            'interest_talent' => 'required|string|max:250',
            'contact' => 'required|string|max:250',
            'reason' => 'required|string|max:250',
            'expectation' => 'required|string|max:250'
        ]);

        if ($user->requestMinitutor !== null){
            $user->requestMinitutor()->update($data);
        } else {
            $requestMinitutor = new RequestMinitutor($data);
            $user->requestMinitutor()->save($requestMinitutor);
        }

        return redirect()->route('join.minitutor.edit')->withSuccess('Permintaan anda untuk menjadi Minitutor telah di update. Silahkan tunngu notifikasi selenjutnta.');
    }
}
