<?php

namespace App\Http\Controllers\Web\Minitutor;

use App\Http\Controllers\Controller;
use App\Model\RequestMinitutor;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;

class JoinMinitutorController extends Controller
{
    const EDUCATIONS = [ 'D1', 'D2', 'D3', 'S1', 'S2', 'S3' ];

    public function index()
    {
        SEOTools::setTitle(setting('seo.joinminitutor.title'));
        SEOTools::setDescription(setting('seo.joinminitutor.description'));
        return view('web.minitutor.join.index');
    }

    public function create(Request $request)
    {
        $user = $request->user();
        if($user->requestMinitutor) {
            return redirect()->route('minitutor.join.edit');
        }
        return view('web.minitutor.join.create', ['last_educations' => self::EDUCATIONS]);
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

        return redirect()->route('minitutor.join.edit')->withSuccess('Permintaan anda untuk menjadi Minitutor telah dibuat. Silahkan tunngu notifikasi selenjutnta');
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        if(!$user->requestMinitutor) {
            return redirect()->route('minitutor.join.create');
        }
        return view('web.minitutor.join.edit', ['last_educations' => self::EDUCATIONS, 'request_minitutor' => $user->requestMinitutor]);
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

        return redirect()->route('minitutor.join.edit')->withSuccess('Permintaan anda untuk menjadi Minitutor telah di update. Silahkan tunngu notifikasi selenjutnta.');
    }
}
