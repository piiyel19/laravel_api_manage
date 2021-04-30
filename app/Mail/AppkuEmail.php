<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppkuEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('sufianmohdhassan19@gmail.com')
                   ->view('emailku')
                   ->with(
                    [
                        'nama' => 'Sufian Mohd Hassan',
                        'website' => 'www.malasngoding.com',
                    ]);
    }
}
