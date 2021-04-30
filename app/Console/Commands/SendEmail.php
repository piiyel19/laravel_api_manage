<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;



//send email
use Illuminate\Http\Request;

use App\Mail\CalendarEmail;
use Illuminate\Support\Facades\Mail;

use DB;
use App\Calendar;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //echo '123';
        #return 0;

        $start = date('Y-m-d H:i');
        $end = date('Y-m-d H:i', strtotime($start. ' + 2 days'));
        
        //echo $end;
        $users = DB::table('calendars')
            ->join('projects', 'calendars.project_id', '=', 'projects.project_id')
            ->select(DB::raw('CONCAT(projects.title, \' - \', calendars.topic) as title'),'calendars.sd as start','calendars.st as end')
            ->where('calendars.achieve','=',0)
            ->where('calendars.sd','>=',$start)
            ->where('calendars.sd','<=',$end)
            ->get();


        Mail::to("sufianmohdhassan19@gmail.com")->send(new CalendarEmail($users));
     
        return "Email telah dikirim";
    }


}
