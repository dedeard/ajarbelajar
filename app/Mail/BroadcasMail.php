<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use GrahamCampbell\Markdown\Facades\Markdown;

class BroadcasMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = '';
    public $body = '';
    public $user = null;

    public function __construct($user, $subject, $body)
    {
        $this->user = $user;
        $this->subject = $this->generate($user, $subject);
        $this->body = Markdown::convertToHtml($this->generate($user, $body));
    }

    private function generate($user, $str) {
        $str = str_replace(':name', $user->name(), $str);
        $str = str_replace(':email', $user->email, $str);
        $str = str_replace(':username', $user->username, $str);
        return $str;
    }

    public function build()
    {
        return $this->subject($this->subject)->markdown('emails.broadcast-mail', ['body' => Markdown::convertToHtml($this->body)]);
    }
}
