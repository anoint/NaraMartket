<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Notifications\ListChange;

class getListNo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:listKorail';

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
        $keyword = '4319150101';
        $endDate = now()->format('YmdHi');
        // $url="http://apis.data.go.kr/1230000/BidPublicInfoService/getBidPblancListInfoThngPPSSrch?ServiceKey=w7UMDibZRQnC5EKAWn4gYDrV%2F4%2B2dgwNVWl2Vl0nIc0lpM0ISjSAy4%2BOEv6A9xxSdHbSBKJTp9qvEt%2Bk72tRqg%3D%3D&inqryDiv=1&bidNtceNm={$keyword}&type=json&pageNo=1&numOfRows=10&inqryBgnDt=202005010000&inqryEndDt=".$endDate;

        $url = "http://apis.data.go.kr/1230000/BidPublicInfoService/getBidPblancListInfoThngPPSSrch?";
        $parameter = [
            "ServiceKey=w7UMDibZRQnC5EKAWn4gYDrV%2F4%2B2dgwNVWl2Vl0nIc0lpM0ISjSAy4%2BOEv6A9xxSdHbSBKJTp9qvEt%2Bk72tRqg%3D%3D&",
            "inqryDiv=1&", 
            "dtilPrdctClsfcNo=".urlencode($keyword)."&",
            "type=json&",
            "pageNo=1&",
            "numOfRows=10&",
            "inqryBgnDt=202005010000&",
            "inqryEndDt=".$endDate
        ];
        $url = $url.implode($parameter);
    
        $client = new Client();
        $res = $client->get($url);
        $html = $res->getBody()->getContents();
        $json = json_decode($html);
        
        $totalCount = $json->response->body->totalCount;
        $list = $json->response->body->items;
        $urls = [];
        $last = last($list);
        
        $item=[
            'url'=>$last->bidNtceDtlUrl,
            'file1'=>$last->ntceSpecDocUrl1,
            'file2'=>$last->ntceSpecDocUrl2
        ];

        $alreadyCount = DB::table('total')->where('key','searchNo')->value("count");
        if($alreadyCount != $totalCount){
            $user = new User();
            $user->email = 'jnyou@everytalk.co.kr';
            $notification = new ListChange($item);
            $user->notify($notification);
            DB::table('total')->where('key','searchNo')->update(['count'=>$totalCount]);
        }
    }
}
