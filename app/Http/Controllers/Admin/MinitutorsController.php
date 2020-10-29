<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MinitutorcvHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Minitutor;
use App\Models\Playlist;
use App\Models\User;
use App\Notifications\RequestMinitutorAcceptedNotification;
use App\Notifications\RequestMinitutorRejectedNotification;
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
        $user->notify(new RequestMinitutorRejectedNotification);
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
        $user->notify(new RequestMinitutorAcceptedNotification);
        return redirect()->route('minitutors.requests')->withSuccess('Permintaan telah di terima.');
    }

    public function edit($id)
    {
        SEOMeta::setTitle('Minitutor');
        $minitutor = Minitutor::findOrFail($id);
        $user = $minitutor->user;
        $last_educations = ['D1', 'D2', 'D3', 'S1', 'S2', 'S3'];
        return view('minitutors.edit', ['minitutor' => $minitutor, 'user' => $user, 'last_educations' => $last_educations]);
    }

    public function update(Request $request, $id)
    {
        $minitutor = Minitutor::findOrFail($id);
        $data = $request->validate([
            'last_education' => 'required|string|max:50',
            'university' => 'required|string|max:250',
            'city_and_country_of_study' => 'required|string|max:250',
            'majors' => 'required|string|max:250',
            'contact' => 'required|string|max:250',
        ]);
        $minitutor->update($data);
        return redirect()->back()->withSuccess('MiniTutor telah diperbarui.');
    }

    public function show($id)
    {
        SEOMeta::setTitle('Minitutor');
        $minitutor = Minitutor::findOrFail($id);
        $user = $minitutor->user;
        return view('minitutors.info', ['minitutor' => $minitutor, 'user' => $user]);
    }

    public function showArticles($id)
    {
        SEOMeta::setTitle('Minitutor');
        $minitutor = Minitutor::findOrFail($id);
        $user = $minitutor->user;
        $articles = Article::postListQuery($minitutor->articles(), true)->get();
        return view('minitutors.articles', ['minitutor' => $minitutor, 'user' => $user, 'articles' => $articles]);
    }

    public function showPlaylists($id)
    {
        SEOMeta::setTitle('Minitutor');
        $minitutor = Minitutor::findOrFail($id);
        $user = $minitutor->user;
        $playlists = Playlist::postListQuery($minitutor->playlists(), true)->get();
        return view('minitutors.playlists', ['minitutor' => $minitutor, 'user' => $user, 'playlists' => $playlists]);
    }

    public function showFollowers($id)
    {
        SEOMeta::setTitle('Minitutor');
        $minitutor = Minitutor::findOrFail($id);
        $user = $minitutor->user;
        $followers = $minitutor->subscribers()->get();
        return view('minitutors.followers', ['minitutor' => $minitutor, 'user' => $user, 'followers' => $followers]);
    }

    public function showFeedback($id)
    {
        SEOMeta::setTitle('Minitutor');
        $minitutor = Minitutor::findOrFail($id);
        $user = $minitutor->user;
        $feedback = $minitutor->feedback;
        return view('minitutors.feedback', ['minitutor' => $minitutor, 'user' => $user, 'data' => $feedback]);
    }

    public function showComments($id)
    {
        SEOMeta::setTitle('Minitutor');
        $minitutor = Minitutor::findOrFail($id);
        $user = $minitutor->user;
        $comments = $minitutor->comments;
        return view('minitutors.comments', ['minitutor' => $minitutor, 'user' => $user, 'comments' => $comments]);
    }
}
