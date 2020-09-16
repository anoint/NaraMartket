<?php

namespace App\Console\Commands;

use Illuminate\Console\Command; 
use Illuminate\Support\Facades\DB;
use App\User;
use App\Notifications\SendIssue;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\tta;
class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:sendMail';

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
        $oClient = Client::account('default');
        $oClient->connect();
        $box = $oClient->getFolders()->first();
        // $Mails = $box->query()->unseen()->from('spyu@tta.or.kr')->markAsRead()->get();
        $Mails = $box->query()->unseen()->from('jhs.wed@everytalk.co.kr')->markAsRead()->get();
        $count = $Mails->count();
        if($count)
        {
            $Mails->each(function ($mail) {
                // $user = new User();
                // $user->email = 'jnyou@everytalk.co.kr'; 
                // $notification = new SendIssue($mail);
                // $user->notify($notification);
                Mail::to(collect([
                    new User([
                        'email'=>'jnyou@everytalk.co.kr',
                        'name'=>'유지나',
                    ]),
                    new User([
                        'email'=>'kimyu711@naver.com',
                        'name'=>'김영웅',
                    ])
                ]))->send(new tta($mail));
            });
        }
    }
}
