<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Minitutor;
use App\Models\RequestMinitutor;
use App\Notifications\RequestMinitutorAccepted;
use App\Notifications\RequestMinitutorRejected;
use Illuminate\Support\Facades\Storage;

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
        if(Storage::disk('public')->exists('minitutor/video/' . $data->video)){
            Storage::disk('public')->delete('minitutor/video/' . $data->video);
        }
        if(Storage::disk('public')->exists('minitutor/cv/' . $data->cv)){
            Storage::disk('public')->delete('minitutor/cv/' . $data->cv);
        }
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
        unset($requestDataCopy['video']);

        if(Storage::disk('public')->exists('minitutor/video/' . $requestData->video)){
            Storage::disk('public')->delete('minitutor/video/' . $requestData->video);
        }

        $requestDataCopy['active'] = true;
        Minitutor::create($requestDataCopy);
        $requestData->user->notify(new RequestMinitutorAccepted);
        $requestData->delete();
        return redirect()->route('admin.minitutor.request.index')->withSuccess('Permintaan telah di terima.');
    }
}
