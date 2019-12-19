<!-- resources/views/review.blade.phpとして保存 -->

@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>ここはメインのサイドバーに追加される</p>
@endsection




{{-- @endsection

@section('content-main') --}}

    @php

    // 単語感情極性対応表ファイル読み込み
    if (($handle = fopen("negaposi.txt", "r")) !== FALSE) {
    // 1行ずつfgets()関数を使って読み込む
        while (($data = fgets($handle))) {
            #ネガポジ[それぞれの単語][漢字，かな，品詞，スコア]の形でひとつずつ追加
            #negaposi[0][0]は「優れる」，[0][1]は「すぐれる」...
            $negaposi[] = explode(":",$data);
        }
        fclose($handle);
    }else {
        echo "たんごかんじょうきょくせいたいおうひょうファイルがないゾ";
    }

    /**
    * Yahoo! JAPAN Web APIのご利用には、アプリケーションIDの登録が必要です。
    * あなたが登録したアプリケーションIDを $appid に設定してお使いください。
    * アプリケーションIDの登録URLは、こちらです↓
    * http://e.developer.yahoo.co.jp/webservices/register_application
    */
    
    function escapestring($str) {
        return htmlspecialchars($str, ENT_QUOTES);
    }
    if (isset($_POST['sentence'])) {
        $sentence = mb_convert_encoding($_POST['sentence'], 'utf-8', 'auto');
    }
    else {
        $sentence = "";
    }
    if (isset($_POST['ma_response'])) {
        $ma_response = join(",", array_values($_POST['ma_response']));
        $arr_response = $_POST['ma_response'];
    }
    else {
        $ma_response = "";
        $arr_response = array();
    }
    if (isset($_POST['ma_filter'])) {
        $ma_filter = join("|", array_values($_POST['ma_filter']));
        $arr_filter = $_POST['ma_filter'];
    }
    else {
        $ma_filter = "";
        $arr_filter = array();
    }

    $final_result = 0;
    $final_count = 0;
    $avg_f =0;
    $hit = 0;

    for ($i=0; $i < $count; $i++) { 
        $score=0;
        $np_num=0;
        $result=0;
        $result_f =0;
        $sentence = $hash[$i]->text;
        // dump($sentence);
        $tweet_text[] = $sentence;



        // dump($sentence);
        if ($sentence != "") {
            $yahooAPI_url = "http://jlp.yahooapis.jp/MAService/V1/parse?appid=".$appid."&results=ma";
            $yahooAPI_url .= "&sentence=".urlencode($sentence);
            $xml  = simplexml_load_file($yahooAPI_url);
            $cnt = count($xml->ma_result->word_list->word);
            for ($k=0; $k < $cnt ; $k++) {
                $test[] = $xml->ma_result->word_list->word[$k]->surface;
                // dump($test);
            }

            for ($j=0; $j < $cnt ; $j++) { 
                for($tango=0; $tango<(count($negaposi)); $tango++){
                    if (mb_strpos($test[$j],$negaposi[$tango][0]) !== false){
                        //含まれている場合
                        // echo "-----",$negaposi[$tango][0],",",$negaposi[$tango][1],"-----<br />";
                        // echo "対象から最後まで: ", strstr($test[$j],$negaposi[$tango][0]),"<br />";
                        // echo "位置は: ", mb_strpos($test[$j],$negaposi[$tango][0]),"<br />";
                        // echo "スコアは: ",$negaposi[$tango][3],"<br >";
                        $result_f = 1;
                        $avg_f++;
                        $score = $score + (float)$negaposi[$tango][3]; #スコア加算
                        $final_result = $final_result + (float)$negaposi[$tango][3];
                        $np_num++; #平均算出用
                        $final_count++;
                        #まだ同じ単語があるか判定
                        $pos = mb_strpos($test[$j],$negaposi[$tango][0]);#感情文字のある場所
                        $np_arr = strstr($test[$j],$negaposi[$tango][0]);#対象から最後まで
                        $lentan = mb_strlen($negaposi[$tango][0]); #感情単語の長さ
                        $strlen = mb_strlen($np_arr); #切り出したあとの長さ
                        $aaanp_arr = mb_substr($test[$j],($pos+$lentan),($strlen-$lentan));#対象+単語分から最後まで
                        $tan_num = 0; #単語の数
                        while(mb_strpos($aaanp_arr,$negaposi[$tango][0]) !== false){
                            $tan_num++;
                            $pos2 = mb_strpos($aaanp_arr,$negaposi[$tango][0]);
                            $np_arr2 = strstr($aaanp_arr,$negaposi[$tango][0]);#対象から最後まで
                            $aaanp_arr = mb_substr($aaanp_arr,($pos2+$lentan),($strlen-1));#対象+単語分から最後まで
    
                            $score = $score + (float)$negaposi[$tango][3]; #スコア加算
                            $final_result = $final_result + (float)$negaposi[$tango][3];
                            $np_num++; #平均算出用
                            $final_count++; 
                        }
                    }else{
                        //含まれていない場合　
                    }
                }
            }
        }
        if ($result_f != 0) {
            # code...
            $result = $score/$np_num;
            $tweet_result[] = $result;
            // echo "======このツイートの平均: ",$result,"======<br />";
        }else{
            $tweet_result[] = 0;
            // echo "$i ツイート目には一致する単語はありません<br />";
        }

        // echo "-----------------------------------------------------------------<br />";
        if($test!=NULL){
            unset($test);
            $hit++;
        }
    }

    if ($avg_f != 0) {
        # code...
        $final = $final_result/$final_count;
        if ($final <= -0.5 && $final > -1.0) {
            $rank = '△(好きな人には好きな味?)';
        } elseif ($final <= -0.2 && $final > -0.) {
            $rank = '○(まあまあオススメ!)';
        } else {
            $rank = '◎(かなりオススメ!)';
        }
        echo "======ヒットした", $hit, "ツイート全ての平均スコア: ",$final,"======<br />";
    }else{
        echo "ヒットなし<br />";
    }
    @endphp

@section('content')
{{-- {{$keyword}} --}}
<h1>「{{'#'.$tag}}」に関する判定結果</h1>
<center><h2>{{$rank}}</h2></center>
<h3>
@php
    $test = array_keys($tweet_result, max($tweet_result));
    echo $tweet_text[$test[0]];
@endphp
</h3>
    
<div class="container-fluid">
    @for ($i = 0; $i < $count; $i++)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">{{$i+1}}ツイート目</h5>
                    <div class="card-body">
                        {{$tweet_text[$i]}}
                    </div>
                    <div class="card-footer">
                        <h5 align="right"> 本ツイートのスコア : {{$tweet_result[$i]}}</h5>
                    </div>
                </div>
            </div> 
        </div>
        <br>
    @endfor
</div>

@endsection