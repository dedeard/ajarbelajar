<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Minitutor;

class MinitutorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:manage minitutor']);
    }

    public function index()
    {
        $minitutors = Minitutor::paginate(20);
        return view('admin.minitutor.index', ['minitutors' => $minitutors ]);
    }

    public function show($id)
    {
        $minitutor = Minitutor::findOrFail($id);
        return view('admin.minitutor.show', ['minitutor' => $minitutor ]);
    }

    public function activeToggle($id)
    {
        $minitutor = Minitutor::findOrfail($id);

        if($minitutor->user->hasRole('Super Admin')) {
            return abort(403);
        }

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

        if($minitutor->user->hasRole('Super Admin')) {
            return abort(403);
        }

        $minitutor->delete();
        return redirect()->back()->withSuccess('Berhasil menghapus pengguna sebagai minitutor.');
    }
}
