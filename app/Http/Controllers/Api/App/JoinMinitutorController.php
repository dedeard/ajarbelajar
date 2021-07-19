<?php

namespace App\Http\Controllers\Api\App;

use App\Helpers\MinitutorcvHelper;
use App\Http\Controllers\Controller;
use App\Models\JoinMinitutor;
use Illuminate\Http\Request;

class JoinMinitutorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'not.minitutor']);
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $join = $user->joinMinitutor;
        if ($join) {
            $data = $join->toArray();
            $data['cv'] = $join->cvUrl;
            return response()->json($data, 200);
        }
        return response()->json(["message" => __("You have submitted a request to become a minitutor.")], 403);
    }

    public function status(Request $request)
    {
        $user = $request->user();
        $alowCreate = true;
        if ($user->joinMinitutor) {
            $alowCreate = false;
        }

        return response()->json(["allowCreate" => $alowCreate], 200);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if ($user->joinMinitutor) {
            return response()->json(["message" => __("You have submitted a request to become a minitutor.")], 403);
        }
        $data = $request->validate([
            'last_education' => 'required|string|max:255',
            'university' => 'required|string|max:255',
            'city_and_country_of_study' => 'required|string|max:255',
            'majors' => 'required|string|max:255',
            'interest_talent' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'reason' => 'required|string|max:255',
            'expectation' => 'required|string|max:255',
            'cv' => 'required|mimes:pdf|max:10000',
        ]);
        $data['cv'] = MinitutorcvHelper::generate($data['cv']);
        $joinMinitutor = new JoinMinitutor($data);
        $user->joinMinitutor()->save($joinMinitutor);
        return response()->noContent();
    }
}
