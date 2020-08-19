<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Minitutor;
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
                return $q->where('first_name', 'like', $search)
                    ->orWhere('last_name', 'like', $search)
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

    public function destroy($id)
    {
        $minitutor = Minitutor::findOrFail($id);
        $minitutor->delete();
        return redirect()->route('minitutors.index')->withSuccess('Berhasil menghapus pengguna sebagai minitutor.');
    }
}
