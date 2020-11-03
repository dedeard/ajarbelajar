<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\MailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class EmailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage email');
    }

    public function index()
    {
        return redirect()->route('emails.broadcast');
    }

    public function broadcast()
    {
        $target = ['user' => 'Pengguna biasa', 'minitutor' => 'MiniTutor', 'user:minitutor' => 'Pengguna dan Minitutor'];
        return view('emails.broadcast', ['targets' => $target]);
    }

    public function sendBroadcastEmails(Request $request)
    {
        $data = $request->validate([
            'target' => 'required|string|in:user,minitutor,user:minitutor',
            'subject' => 'required|string',
            'body' => 'required|string'
        ]);

        switch($data['target']) {
            case 'user':
                $users = User::select(['id', 'email'])
                ->doesntHave('minitutor')
                ->get();
            break;
            case 'minitutor':
                $users = User::select(['id', 'email'])
                ->whereHas('minitutor')
                ->get();
            break;
            case 'user:minitutor':
                $users = User::select(['email'])
                ->get();
            break;
        }

        foreach($users as $user) {
            $user->notify((new MailNotification($data)));
        }

        return redirect()->route('emails.broadcast')->withSuccess('Email dalam proses pengiriman..');
    }

    public function private()
    {
        return view('emails.private');
    }

    public function sendPrivateEmail(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email:rfc,dns',
            'subject' => 'required|string',
            'body' => 'required|string'
        ]);
        Notification::route('mail', $data['email'])->notify((new MailNotification($data)));
        return redirect()->route('emails.private')->withSuccess('Email dalam proses pengiriman..');
    }
}
