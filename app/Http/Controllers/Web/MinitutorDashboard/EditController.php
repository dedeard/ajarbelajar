<?php

namespace App\Http\Controllers\Web\MinitutorDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditController extends Controller
{
    const EDUCATIONS = [ 'D1', 'D2', 'D3', 'S1', 'S2', 'S3' ];

    public function index(Request $request)
    {
        return view('web.minitutor-dashboard.edit', ['last_educations' => self::EDUCATIONS]);
    }
    public function update(Request $request)
    {
        $data = $request->validate([
            'last_education' => 'required|string|in:' . implode(',', self::EDUCATIONS) . '|max:50',
            'university' => 'required|string|max:250',
            'city_and_country_of_study' => 'required|string|max:250',
            'majors' => 'required|string|max:250',
            'interest_talent' => 'required|string|max:250',
            'contact' => 'required|string|max:250',
            'reason' => 'required|string|max:250',
            'expectation' => 'required|string|max:250'
        ]);

        if(isset($request->user()->minitutor)) {
            $request->user()->minitutor->update($data);
        }
        return redirect()->back()->withSuccess("Informasi MiniTutor telah di update.");
    }
}
