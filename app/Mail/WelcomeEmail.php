<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $token;
    public $uid;
    public function __construct($token,$uid)
    {
        $this->token = $token;
        $this->uid = $uid;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = $this->token['name'];
        $email = $this->token['email'];
        $uid = $this->uid;

        //return $this->view('view.name');
        return $this->from('sufianmohdhassan19@gmail.com')
                   ->view('email_welcome')
                   ->with(
                    [
                        'name' => $name,
                        'uid' => $uid,
                    ]);
    }
}
