<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Minitutor;
use Illuminate\Http\Request;

class MinitutorController extends Controller
{
    public function index()
    {
        $minitutors = [];
        foreach(Minitutor::all() as $minitutor) {
            array_push($minitutors, [
                'id' => $minitutor->id,
                'name' => $minitutor->user->name(),
                'username' => $minitutor->user->username,
                'email' => $minitutor->user->email,
                'active' => $minitutor->active ? 'Aktiv' : 'Tidak Aktiv',
                "created_at" => $minitutor->created_at->format('Y/m/d'),
            ]);
        }

        return view('admin.minitutor.index', ['minitutors' => $minitutors]);
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
        return redirect()->back()->withSuccess('Berhasil menghapus pengguna sebagai minitutor.');
    }
}
