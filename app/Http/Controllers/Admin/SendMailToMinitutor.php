<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\BoroadcastMailToMinitutor;
use App\Model\Minitutor;

class SendMailToMinitutor extends Controller
{
    public function index()
    {
        return view('admin.mail.minitutor');
    }
    public function send(Request $request)
    {
        foreach(Minitutor::all() as $minitutor){
            $email = $minitutor->user->email;
            if($email) {
                $job = (new BoroadcastMailToMinitutor($email, $request->subject, $request->body))->delay(5);
                $this->dispatch($job);
            }
        }
        return redirect()->back()->withSuccess('ok email dikirim ke semua mini tutor');
    }
}
