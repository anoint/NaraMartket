<?php

namespace App\Console\Commands;

use App\Notifications\OpinionChange;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TotalCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:total';

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
        $url = "http://apis.data.go.kr/1230000/HrcspSsstndrdInfoService/getPublicPrcureThngOpinionInfoThng?inqryDiv=2&pageNo=1&numOfRows=10&ServiceKey=w7UMDibZRQnC5EKAWn4gYDrV%2F4%2B2dgwNVWl2Vl0nIc0lpM0ISjSAy4%2BOEv6A9xxSdHbSBKJTp9qvEt%2Bk72tRqg%3D%3D&type=json&bfSpecRgstNo=896772";
        $client = new Client();
        $res = $client->get($url);
        $html = $res->getBody()->getContents();
        $json = json_decode($html);
        $totalCount = $json->response->body->totalCount;
        $alreadyCount = DB::table('total')->where('key','comment')->count;
        if($alreadyCount != $totalCount){
            $user = new User();
            $user->email = 'jnyou@everytalk.co.kr';
            $notification = new OpinionChange();
            $user->notify($notification);
            DB::table('total')->where('key','comment')->update(['count'=>$totalCount]);
        }
    }
}
