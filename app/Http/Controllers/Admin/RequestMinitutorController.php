<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Minitutor;
use App\Model\RequestMinitutor;
use Illuminate\Http\Request;

class RequestMinitutorController extends Controller
{
    public function index(Request $request)
    {
        $requestLists = [];
        foreach(RequestMinitutor::all() as $requestList) {
            array_push($requestLists, [
                'id' => $requestList->id,
                'name' => $requestList->user->name(),
                'username' => $requestList->user->username,
                'email' => $requestList->user->email,
                "updated_at" => $requestList->updated_at->format('Y/m/d'),
                "created_at" => $requestList->created_at->format('Y/m/d'),
            ]);
        }

        return view('admin.minitutor.request', ["requestLists" => $requestLists]);
    }

    public function show($id)
    {
        $data = RequestMinitutor::findOrFail($id);
        return view('admin.minitutor.showRequest', ["data" => $data]);
    }

    public function reject($id)
    {
        RequestMinitutor::findOrFail($id)->delete();
        return redirect()->route('admin.minitutor.request.index')->withSuccess('Permintaan telah di ditolak.');
    }

    public function accept($id)
    {
        $requestData = RequestMinitutor::findOrFail($id);
        $requestDataCopy = $requestData;
        $requestDataCopy = $requestDataCopy->toArray();

        unset($requestDataCopy['created_at']);
        unset($requestDataCopy['updated_at']);
        unset($requestDataCopy['id']);

        $requestDataCopy['active'] = true;
        Minitutor::create($requestDataCopy);
        $requestData->delete();
        return redirect()->route('admin.minitutor.request.index')->withSuccess('Permintaan telah di terima.');
    }
}
