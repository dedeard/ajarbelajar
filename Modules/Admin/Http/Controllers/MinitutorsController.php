<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Minitutor;
use App\Models\RequestMinitutor;
use App\Notifications\RequestMinitutorAccepted;
use App\Notifications\RequestMinitutorRejected;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class MinitutorsController extends Controller
{

  public function __construct()
  {
      $this->middleware(['permission:manage minitutor']);
  }

  public function index(Request $request)
  {
    if(!empty($request->input('search'))) {
      $search = '%'. $request->input('search') .'%';
      $minitutors = Minitutor::whereHas('user', function($q) use ($search){
        return $q->where('first_name', 'like', $search)
          ->orWhere('last_name', 'like', $search)
          ->orWhere('username', 'like', $search)
          ->orWhere('email', 'like', $search);
      })->orderBy('id', 'desc');
    } else {
      $minitutors = Minitutor::orderBy('id', 'desc');
    }
    $minitutors = $minitutors->paginate(20)->appends(['search' => $request->input('search')]);
    return view('admin::minitutors.index', ['minitutors' => $minitutors]);
  }

  public function show($id)
  {
    $minitutor = Minitutor::findOrFail($id);
    $user = $minitutor->user;
    return view('admin::minitutors.show', ['minitutor' => $minitutor, 'user' => $user]);
  }


  public function activeToggle($id)
  {
    $minitutor = Minitutor::findOrfail($id);
    if($minitutor->active) {
      $minitutor->active = false;
      $message = "Berhasil menonaktivkan Minitutor";
    } else {
      $minitutor->active = true;
      $message = "Berhasil mengaktivkan Minitutor";
    }
    $minitutor->save();
    return redirect()->back()->withSuccess($message);
  }

  public function destroy($id)
  {
    $minitutor = Minitutor::findOrFail($id);
    $minitutor->delete();
    return redirect()->route('admin.minitutors.index')->withSuccess('Berhasil menghapus pengguna sebagai minitutor.');
  }

  public function requests(Request $request)
  {
    if(!empty($request->input('search'))) {
      $search = '%'. $request->input('search') .'%';
      $data = RequestMinitutor::whereHas('user', function($q) use ($search){
        return $q->where('first_name', 'like', $search)
          ->orWhere('last_name', 'like', $search)
          ->orWhere('username', 'like', $search)
          ->orWhere('email', 'like', $search);
      })->orderBy('id', 'desc');
    } else {
      $data = RequestMinitutor::orderBy('id', 'desc');
    }
    $data = $data->paginate(20)->appends(['search' => $request->input('search')]);
    return view('admin::minitutors.requests', [ 'requests' => $data ]);
  }

  public function showRequest($id)
  {
    $data = RequestMinitutor::findOrFail($id);
    return view('admin::minitutors.show_request', ["data" => $data]);
  }

  public function rejectRequest($id)
  {
    $data = RequestMinitutor::findOrFail($id);
    if(Storage::exists('minitutor/video/' . $data->video)){
      Storage::delete('minitutor/video/' . $data->video);
    }
    if(Storage::exists('minitutor/cv/' . $data->cv)){
      Storage::delete('minitutor/cv/' . $data->cv);
    }
    $data->user->notify(new RequestMinitutorRejected);
    $data->delete();
    return redirect()->route('admin.minitutors.requests')->withSuccess('Permintaan telah di ditolak.');
  }

  public function acceptRequest($id)
  {
    $requestData = RequestMinitutor::findOrFail($id);
    $requestDataCopy = $requestData;
    $requestDataCopy = $requestDataCopy->toArray();

    unset($requestDataCopy['created_at']);
    unset($requestDataCopy['updated_at']);
    unset($requestDataCopy['id']);
    unset($requestDataCopy['video']);

    if(Storage::exists('minitutor/video/' . $requestData->video)){
      Storage::delete('minitutor/video/' . $requestData->video);
    }

    $requestDataCopy['active'] = true;
    Minitutor::create($requestDataCopy);
    $requestData->user->notify(new RequestMinitutorAccepted);
    $requestData->delete();
    return redirect()->route('admin.minitutors.requests')->withSuccess('Permintaan telah di terima.');
  }
}
