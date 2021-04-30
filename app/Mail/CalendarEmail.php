<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CalendarEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        #return $this->view('view.name');
        $data = $this->data;

        $viewer = '';
        $x = '1';
        foreach($data as $view) {
            $t = $view->title;
            $s = $view->start;
            if(!empty($s)){$s = date('d/m/Y H:i', strtotime($s));}
            
            $e = $view->end;
            if(!empty($e)){ $e = date('d/m/Y H:i', strtotime($e));}
            

            $viewer .= '<h3>'.$x.') '.$t.'</h3><p>Start Date : '.$s.'</p><p>End Date : '.$e.'</p><hr>';
            $x++;
        }

        //dd($viewer);
        //echo $viewer; exit();

        if(!empty($viewer)){
            return $this->from('sufianmohdhassan19@gmail.com')
                   ->view('cronjob')
                   ->with(
                    [
                        'viewer' => $viewer
                    ]);
        } else {
            return '';
        }

        
    }
}
