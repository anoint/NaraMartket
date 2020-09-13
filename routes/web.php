<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $url = "http://apis.data.go.kr/1230000/HrcspSsstndrdInfoService/getPublicPrcureThngOpinionInfoThng?inqryDiv=2&pageNo=1&numOfRows=10&ServiceKey=w7UMDibZRQnC5EKAWn4gYDrV%2F4%2B2dgwNVWl2Vl0nIc0lpM0ISjSAy4%2BOEv6A9xxSdHbSBKJTp9qvEt%2Bk72tRqg%3D%3D&type=json&bfSpecRgstNo=896772";
    $client = new Client();
    $res = $client->get($url);
    $html = $res->getBody()->getContents();
    $json = json_decode($html);
    $totalCount = $json->response->body->totalCount;

    return view('welcome',['json'=>$totalCount]);
});

Route::get('/search',function () {
    $key = '휴대전화기';
    $endDate = now()->format('YmdHi');
    $url="http://apis.data.go.kr/1230000/BidPublicInfoService/getBidPblancListInfoThngPPSSrch?ServiceKey=w7UMDibZRQnC5EKAWn4gYDrV%2F4%2B2dgwNVWl2Vl0nIc0lpM0ISjSAy4%2BOEv6A9xxSdHbSBKJTp9qvEt%2Bk72tRqg%3D%3D&inqryDiv=1&bidNtceNm={$key}&type=json&pageNo=1&numOfRows=10&inqryBgnDt=202005010000&inqryEndDt=".$endDate;
    $client = new Client();
    $res = $client->get($url);
    $html = $res->getBody()->getContents();
    $json = json_decode($html);
    $totalCount = $json->response->body->totalCount;
    return view('welcome',['json'=>$totalCount]);

});
 