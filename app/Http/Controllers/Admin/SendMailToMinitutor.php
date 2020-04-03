<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\BoroadcastMailToMinitutor;

class SendMailToMinitutor extends Controller
{
    public function index()
    {
        return view('admin.mail.minitutor');
    }
    public function send(Request $request)
    {
        // dd($request->body);
        $emails = ['dedeariansya1@gmail.com', 'arddede4@gmail.com', 'ajarbelajarcom@gmail.com'];
        foreach($emails as $email) {
            $job = (new BoroadcastMailToMinitutor('dedeariansya1@gmail.com', $request->subject, $request->body))->delay(5);
            $this->dispatch($job);
        }
        return view('admin.mail.minitutor');
    }
}
