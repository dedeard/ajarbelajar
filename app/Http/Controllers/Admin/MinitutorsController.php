<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MinitutorcvHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Minitutor;
use App\Models\JoinMinitutor;
use App\Models\Playlist;
use App\Models\User;
use App\Notifications\RequestMinitutorAcceptedNotification;
use App\Notifications\RequestMinitutorRejectedNotification;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;

class MinitutorsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:manage minitutor']);
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
        $joinMinitutors = JoinMinitutor::with('user');
        $data = $joinMinitutors->paginate(20)->appends(['search' => $request->input('search')]);
        return view('minitutors.requests', [ 'requests' => $data ]);
    }

    public function showRequest($id)
    {
        SEOMeta::setTitle("Permintaan manjadi Minitutor");
        $joinMinitutor = JoinMinitutor::findOrFail($id);
        return view('minitutors.show_request', ["user" => $joinMinitutor->user, 'data' => $joinMinitutor]);
    }

    public function rejectRequest($id)
    {
        $data = JoinMinitutor::findOrFail($id);
        $user = $data->user;
        MinitutorcvHelper::destroy($data['cv']);
        $data->delete();
        $user->notify(new RequestMinitutorRejectedNotification);
        return redirect()->route('minitutors.requests')->withSuccess('Permintaan telah di ditolak.');
    }

    public function acceptRequest($id)
    {
        $data = JoinMinitutor::findOrFail($id);
        $user = $data->user;
        $arr = $data->toArray();
        MinitutorcvHelper::destroy($arr['cv']);
        unset($arr['created_at']);
        unset($arr['cv']);
        unset($arr['id']);
        unset($arr['user']);
        unset($arr['user_id']);
        unset($arr['updated_at']);
        $arr['active'] = true;
        $minitutor = new Minitutor($arr);
        $user->minitutor()->save($minitutor);
        $data->delete();
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
