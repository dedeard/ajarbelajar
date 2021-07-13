<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MinitutorcvHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Database;

class JoinMinitutorController extends Controller
{
    public function __construct(Database $database)
    {
        $this->middleware(['auth:sanctum', 'not.minitutor']);
        $this->database = $database;
    }

    private function getRef($user)
    {
        $uid = (string) $user->id;
        return $this->database->getReference('request_minitutor/_' . $uid);
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $ref = $this->getRef($user);
        $snap = $ref->getSnapshot();
        if($snap->exists()) {
            $data = $snap->getValue();
            $data['cv'] = MinitutorcvHelper::getUrl($data['cv']);
            return response()->json($data, 200);
        }
        return response()->json(["message" => __("You have submitted a request to become a minitutor.")], 403);
    }

    public function status(Request $request)
    {
        $user = $request->user();
        $ref = $this->getRef($user);
        $snap = $ref->getSnapshot();
        $alowCreate = true;
        if($snap->exists()) $alowCreate = false;
        return response()->json(["allowCreate" => $alowCreate], 200);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $ref = $this->getRef($user);

        if($ref->getSnapshot()->exists()) {
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

        $ref->set(array_merge($data, ['created_at' =>  ['.sv' => 'timestamp']]));

        return response()->json([], 200);
    }
}
