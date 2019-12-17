<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Keyword_database;
use Abraham\TwitterOAuth\TwitterOAuth;


class PagesController extends Controller
{

    public function index()
    {
        $tags = Tag::orderby('ID', 'asc')->Paginate(10);

        return view('pages.index')->with('tags', $tags);
    }

    public function test()
    {
        // $data = $request->get('select_tag'); // 全データを連想配列で取得
        // return view('pages.review')->with('data', $data);
        return view('pages.test');

    }

    public function judge(Request $request)
    {
        // $tag = $request->tag;
        // dd($request);
        $tag = $request->post_tag;
        $test_tag = $request->post_test_tag;
        $count = $request->count;
        $since = $request->since. "_00:00:00_JST";
        $until_before = date("Y-m-d_H:i:s_e");
        $until = str_replace('Asia/Tokyo', 'JST', $until_before);
        // dd($test_tag);
        
        //ツイートを5件取得

        // '#'.$tag
        // $result = \Twitter::get('statuses/home_timeline', array("count" => 15));
        if($test_tag==NULL) {
            $hash_params = ['q' => '#'.$tag, 'count' => $count, 'lang' => 'ja', 'since' => $since, 'until' => $until];
            $hash = \Twitter::get('search/tweets', $hash_params)->statuses;
            if ($hash == null) {
                session()->flash('flash_message', 'ツイート情報がありません');
                return redirect('/');
            }


            $url = 'https://devomouua.cybozu.com/k/v1/records.json?app=4';
            $headers = [
                'X-Cybozu-API-Token: 7GMsxmVkzass7ZkT9IRytGWJ5rsldY563vKJ331j',
                'Content-Type: application/json'
            ];


            // $keywords = Keyword_database::where('tag', $tag)->orderby('ID', 'asc')->get();//pagenateするとtake(3)が無視される
            return view('pages.review', [
                "hash" => $hash, "url" => $url, "headers" => $headers, "tag" => $tag, "count" => $count
            ]);
        } else {
            $hash_params = ['q' => '#'.$test_tag, 'count' => $count, 'lang' => 'ja', 'since' => $since, 'until' => $until];
            $hash = \Twitter::get('search/tweets', $hash_params)->statuses;
            if ($hash == null) {
                session()->flash('flash_message', 'ツイート情報がありません');
                return redirect('/');
            }


            $url = 'https://devomouua.cybozu.com/k/v1/records.json?app=4';
            $headers = [
                'X-Cybozu-API-Token: 7GMsxmVkzass7ZkT9IRytGWJ5rsldY563vKJ331j',
                'Content-Type: application/json'
            ];


            // $keywords = Keyword_database::where('tag', $tag)->orderby('ID', 'asc')->get();//pagenateするとtake(3)が無視される
            return view('pages.review', [
                "hash" => $hash, "url" => $url, "headers" => $headers, "tag" => $test_tag, "count" => $count
            ]);
        }
    }
    

    public function twitter(Request $request)
    {
        //ツイートを5件取得
        $result = \Twitter::get('statuses/home_timeline', array("count" => 5));
        $hash_params = ['q' => '#HackFuture', 'count' => '5', 'lang' => 'ja', 'since' => '2019-12-15_12:00:00_JST', 'until' => '2019-12-15_15:00:00_JST'];
        $hash = \Twitter::get('search/tweets', $hash_params)->statuses;
        dump($hash);




        $url = 'https://devomouua.cybozu.com/k/v1/record.json';
        $headers = [
            'X-Cybozu-API-Token: WVM0OxyFErPOOuV8T4khJgPXkEMNZr081WNngESm',
            'Content-Type: application/json'
        ];

        //ViewのTwitter.blade.phpに渡す
        return view('pages.twitter', [
            "hash" => $hash, "url" => $url, "headers" => $headers
        ]);
    }


}
