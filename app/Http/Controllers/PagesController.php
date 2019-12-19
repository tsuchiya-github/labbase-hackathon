<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function index()
    {
        $url = env("kintone_url");
        $headers = [
            'X-Cybozu-API-Token: ' . env("kintone_shop_token"),
        ];
        
        return view('pages.index', [
            "url" => $url, "headers" => $headers
        ]);
    }

    public function judge(Request $request)
    {
        ini_set("max_execution_time", 0); // タイムアウトしない
        $tag = $request->post_tag;
        $test_tag = $request->post_test_tag;
        $count = $request->count;
        $lastweek_before = date('Y-m-d_H:i:s_e', strtotime('-1 week', time()));
        $lastweek = str_replace('Asia/Tokyo', 'JST', $lastweek_before);
        $until_before = date("Y-m-d_H:i:s_e");
        $until = str_replace('Asia/Tokyo', 'JST', $until_before);
        $appid = env('appid');// '<あなたのアプリケーションID>'; // <-- ここにあなたのアプリケーションIDを設定してください。


        if($test_tag==NULL) {
            $hash_params = ['q' => '#'.$tag, 'count' => $count, 'lang' => 'ja', 'since' => $lastweek, 'until' => $until, 'exclude' => 'retweets'];
            $hash = \Twitter::get('search/tweets', $hash_params)->statuses;
            if ($hash == null) {
                session()->flash('flash_message', 'ツイート情報がありません');
                return redirect('/');
            }
            return view('pages.review', [
                "hash" => $hash, "tag" => $tag, "count" => $count, "appid" => $appid
            ]);
        } else {
            $hash_params = ['q' => '#'.$test_tag, 'count' => $count, 'lang' => 'ja', 'since' => $lastweek, 'until' => $until];
            $hash = \Twitter::get('search/tweets', $hash_params)->statuses;
            if ($hash == null) {
                session()->flash('flash_message', 'ツイート情報がありません');
                return redirect('/');
            }
            return view('pages.review', [
                "hash" => $hash, "tag" => $test_tag, "count" => $count, "appid" => $appid
            ]);
        }
    }
}
