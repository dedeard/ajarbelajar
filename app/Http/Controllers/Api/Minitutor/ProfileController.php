<?php

namespace App\Http\Controllers\Api\Minitutor;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinitutorResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'last_education' => 'required|string|max:255',
            'university' => 'required|string|max:255',
            'city_and_country_of_study' => 'required|string|max:255',
            'majors' => 'required|string|max:255',
        ]);
        $user->minitutor->update($data);
        return response()->json(MinitutorResource::make($user->minitutor), 200);
    }
}
