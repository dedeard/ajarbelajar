<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class BoroadcastMailToMinitutor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $data = [];
    public function __construct($to, $subject, $body)
    {
        $this->data = [
            'to' => $to,
            'subject' => $subject,
            'body' => $body,
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        Mail::send([], [], function($message) use($data) {
            $message->to($data['to'])
                    ->subject($data['subject'])->to($data['to'])
                    ->setBody($data['body'], 'text/html');
        });
    }
}
