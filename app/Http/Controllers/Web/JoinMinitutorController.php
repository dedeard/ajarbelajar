<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Minitutor;
use App\Model\Post;
use App\Model\RequestMinitutor;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class JoinMinitutorController extends Controller
{
    const EDUCATIONS = [ 'D1', 'D2', 'D3', 'S1', 'S2', 'S3' ];

    public function index()
    {
        $data = [
            'user_count' => User::count(),
            'minitutor_count' => Minitutor::where('active', 1)->count(),
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
            'expectation' => 'required|string|max:250',
            'video' => 'required|mimes:mp4,mov,mkv,avi|max:50000',
            'cv' => 'required|mimes:pdf|max:10000',
        ]);

        if($request->join_group === 'on'){
            $data['join_group'] = true;
        } else {
            $data['join_group'] = false;
        }

        $name = Str::random(60) . '.' . $data['video']->extension();
        Storage::disk('public')->put('minitutor/video/' . $name, file_get_contents($data['video']));
        $data['video'] = $name;

        $name = Str::random(60) . '.' . $data['cv']->extension();
        Storage::disk('public')->put('minitutor/cv/' . $name, file_get_contents($data['cv']));
        $data['cv'] = $name;

        if ($user->requestMinitutor){
            $user->requestMinitutor()->update($data);
        } else {
            $requestMinitutor = new RequestMinitutor($data);
            $user->requestMinitutor()->save($requestMinitutor);
        }

        return redirect()->route('join.minitutor.index')->withSuccess('Permintaan anda untuk menjadi Minitutor telah dibuat. Silahkan tunngu notifikasi selenjutnta');
    }
}
