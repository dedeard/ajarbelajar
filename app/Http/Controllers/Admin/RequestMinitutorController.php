<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Minitutor;
use App\Model\RequestMinitutor;
use App\Notifications\RequestMinitutorAccepted;
use App\Notifications\RequestMinitutorRejected;

class RequestMinitutorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:manage minitutor']);
    }
    
    public function index()
    {
        return view('admin.minitutor.request.index', ["requestMinitutor" => RequestMinitutor::orderBy('id', 'desc')->paginate(20)]);
    }

    public function show($id)
    {
        $data = RequestMinitutor::findOrFail($id);
        return view('admin.minitutor.request.show', ["data" => $data]);
    }

    public function reject($id)
    {
        $data = RequestMinitutor::findOrFail($id);
        $data->user->notify(new RequestMinitutorRejected);
        $data->delete();
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
        $requestData->user->notify(new RequestMinitutorAccepted);
        $requestData->delete();
        return redirect()->route('admin.minitutor.request.index')->withSuccess('Permintaan telah di terima.');
    }
}
