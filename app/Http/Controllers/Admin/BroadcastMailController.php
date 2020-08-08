<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\BroadcastMail;
use App\Models\User;
use Illuminate\Http\Request;

class BroadcastMailController extends Controller
{
    const TARGET = [
        'users' => [
            'name' => 'Semua Pengguna',
            'type' => 'user'
        ],
        'verified_users' => [
            'name' => 'Semua Pengguna yang telah memverifikasi Alamat Email',
            'type' => 'user'
        ],
        'minitutors' => [
            'name' => 'Semua Minitutor',
            'type' => 'minitutor'
        ],
        'active_minitutors' => [
            'name' => 'Semua Minitutor yang aktive',
            'type' => 'minitutor'
        ],
    ];

    public function index()
    {
        return view('admin.broadcast-mail.index', ['targets' => self::TARGET]);
    }

    public function send(Request $request)
    {
        $targets = [];

        foreach(self::TARGET as $k => $v) array_push($targets, $k);

        $data = $request->validate([
            'target' => 'required|string|in:' . implode(',', $targets),
            'subject' => 'required|string',
            'body' => 'required|string'
        ]);

        $users = [];

        switch($data['target']) {
            case 'users' :
                $users = User::select(['id', 'email', 'email_verified_at', 'first_name', 'last_name', 'username'])->get();
            break;
            case 'verified_users' :
                $users = User::select(['id', 'email', 'email_verified_at', 'first_name', 'last_name', 'username'])->whereNotNull('email_verified_at')->get();
            break;
            case 'minitutors' :
                $users = User::select(['id', 'email', 'email_verified_at', 'first_name', 'last_name', 'username'])
                    ->has('minitutor')->get();
            break;
            case 'active_minitutors' :
                $users = User::select(['id', 'email', 'email_verified_at', 'first_name', 'last_name', 'username'])
                        ->whereHas('minitutor', function($q){
                            return $q->select(['id', 'user_id', 'active'])->where('active', 1);
                        })->get();
            break;
        }

        $second = 3;
        foreach($users as $user) {
            BroadcastMail::dispatch($user, $data)->delay(now()->addSeconds($second));
            $second += 3;
        }

        return redirect()->back()->withSuccess('Email telah terkirim.');
    }
}
