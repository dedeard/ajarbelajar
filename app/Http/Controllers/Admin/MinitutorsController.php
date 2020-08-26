<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MinitutorcvHelper;
use App\Http\Controllers\Controller;
use App\Models\Minitutor;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Kreait\Firebase\Database;

class MinitutorsController extends Controller
{
    public function __construct(Database $database)
    {
        $this->middleware(['can:manage minitutor']);
        $this->database = $database;
    }

    private function getRef($user = null)
    {
        if($user) {
            $uid = (string) $user->id;
            return $this->database->getReference('request_minitutor/_' . $uid);
        }
        return $this->database->getReference('request_minitutor');
    }

    public function index(Request $request)
    {
        SEOMeta::setTitle('Daftar Minitutor');
        if (!empty($request->input('search'))) {
            $search = '%' . $request->input('search') . '%';
            $minitutors = Minitutor::whereHas('user', function ($q) use ($search) {
                return $q->where('name', 'like', $search)
                    ->orWhere('username', 'like', $search)
                    ->orWhere('email', 'like', $search);
            })->orderBy('id', 'desc');
        } else {
            $minitutors = Minitutor::orderBy('id', 'desc');
        }
        $minitutors = $minitutors->paginate(20)->appends(['search' => $request->input('search')]);
        return view('minitutors.index', ['minitutors' => $minitutors]);
    }

    public function show($id)
    {
        SEOMeta::setTitle('Minitutor');
        $minitutor = Minitutor::findOrFail($id);
        $user = $minitutor->user;
        return view('minitutors.show', ['minitutor' => $minitutor, 'user' => $user]);
    }

    public function activeToggle($id)
    {
        $minitutor = Minitutor::findOrfail($id);
        if ($minitutor->active) {
            $minitutor->active = false;
            $message = "Berhasil menonaktivkan Minitutor";
        } else {
            $minitutor->active = true;
            $message = "Berhasil mengaktivkan Minitutor";
        }
        $minitutor->save();
        return redirect()->back()->withSuccess($message);
    }

    public function requests(Request $request)
    {
        SEOMeta::setTitle("Daftar permintaan manjadi Minitutor");
        $users = User::query();
        foreach($this->getRef()->getChildKeys() as $key) {
            $id = (Integer) trim($key, '_');
            $users->orWhere('id', $id);
        };
        $users->orderBy('id');
        $data = $users->paginate(20)->appends(['search' => $request->input('search')]);
        return view('minitutors.requests', [ 'users' => $data ]);
    }

    public function showRequest($id)
    {
        SEOMeta::setTitle("Permintaan manjadi Minitutor");
        $user = User::findOrFail($id);
        $snap = $this->getRef($user)->getSnapshot();
        if(!$snap->exists()) return abort(404);
        $data = $snap->getValue();
        $data['cv'] = MinitutorcvHelper::getUrl($data['cv']);
        return view('minitutors.show_request', ["user" => $user, 'data' => (Object) $data]);
    }

    public function rejectRequest($id)
    {
        $user = User::findOrFail($id);
        $ref = $this->getRef($user);
        $snap = $ref->getSnapshot();
        if(!$snap->exists()) return abort(404);
        $data = $snap->getValue();
        MinitutorcvHelper::destroy($data['cv']);
        $ref->remove();
        // $data->user->notify(new RequestMinitutorRejected);
        return redirect()->route('minitutors.requests')->withSuccess('Permintaan telah di ditolak.');
    }

    public function acceptRequest($id)
    {
        $user = User::findOrFail($id);
        $ref = $this->getRef($user);
        $snap = $ref->getSnapshot();
        if(!$snap->exists()) return abort(404);
        $data = $snap->getValue();
        MinitutorcvHelper::destroy($data['cv']);
        unset($data['created_at']);
        unset($data['cv']);
        $data['active'] = true;
        $minitutor = new Minitutor($data);
        $user->minitutor()->save($minitutor);
        $ref->remove();
        // $requestData->user->notify(new RequestMinitutorAccepted);
        return redirect()->route('minitutors.requests')->withSuccess('Permintaan telah di terima.');
    }
}
