<!-- resources/views/review.blade.phpとして保存 -->

@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>ここはメインのサイドバーに追加される</p>
@endsection

@section('content')
{{-- {{$keyword}} --}}
<h1>「{{$tag}}」に関するネガポジ判定結果</h1>
<h3>-1.0...オススメ度:低</h3>
<h3>1.0....オススメ度:高</h3>

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
    $appid = "dj00aiZpPWhLa25Cb25aNXRhQSZzPWNvbnN1bWVyc2VjcmV0Jng9MTg-";// '<あなたのアプリケーションID>'; // <-- ここにあなたのアプリケーションIDを設定してください。
    
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


    for ($i=0; $i < $count; $i++) { 
        $score=0;
        $np_num=0;
        $result=0;
        $result_f =0;
        $sentence = $hash[$i]->text;
        dump($sentence);
        if ($sentence != "") {
            $yahooAPI_url = "http://jlp.yahooapis.jp/MAService/V1/parse?appid=".$appid."&results=ma";
            $yahooAPI_url .= "&sentence=".urlencode($sentence);
            $xml  = simplexml_load_file($yahooAPI_url);
            $judge = $xml->ma_result->word_list->word->surface;
        
        // 確認用！！！！
        // foreach ($xml->ma_result->word_list->word as $cur){echo escapestring($cur->surface)." | "; }
            // dump($xml->ma_result->word_list->word);
            $cnt = count($xml->ma_result->word_list->word);
            for ($j=0; $j < $cnt ; $j++) { 
                // dump($xml->ma_result->word_list->word);
                for($tango=0; $tango<(count($negaposi)); $tango++){
                    // dump($judge[$j]);
                    // dump(count($negaposi));
                    // echo ($judge[$j],$negaposi[$tango][0]);

                    if (mb_strpos($judge[$j],$negaposi[$tango][0]) !== false){
                        //含まれている場合
                        //確認用↓↓↓↓↓↓↓↓
                        echo "-----",$negaposi[$tango][0],",",$negaposi[$tango][1],"-----<br />";
                        echo "対象から最後まで: ", strstr($judge[$j],$negaposi[$tango][0]),"<br />";
                        echo "位置は: ", mb_strpos($judge[$j],$negaposi[$tango][0]),"<br />";
                        echo "スコアは: ",$negaposi[$tango][3],"<br >";
                        //確認用↑↑↑↑↑↑↑↑
                        $result_f = 1;
                        $avg_f++;
                        $score = $score + (float)$negaposi[$tango][3]; #スコア加算
                        $final_result = $final_result + (float)$negaposi[$tango][3];
                        // var_dump($score);
                        $np_num++; #平均算出用
                        $final_count++; 
                        // var_dump($np_num);



                        #まだ同じ単語があるか判定
                        $pos = mb_strpos($judge[$j],$negaposi[$tango][0]);#感情文字のある場所
                        $np_arr = strstr($judge[$j],$negaposi[$tango][0]);#対象から最後まで
                        $lentan = mb_strlen($negaposi[$tango][0]); #感情単語の長さ
                        $strlen = mb_strlen($np_arr); #切り出したあとの長さ
                        $aaanp_arr = mb_substr($judge[$j],($pos+$lentan),($strlen-$lentan));#対象+単語分から最後まで
                        $tan_num = 0; #単語の数
                        while(mb_strpos($aaanp_arr,$negaposi[$tango][0]) !== false){
                            $tan_num++;
                            //確認用↓↓↓↓↓↓↓↓
                            // echo "$aaanp_arr <br />";
                            // echo $negaposi[$tango][0],"(",$negaposi[$tango][1],")は" ,$tan_num+1,"個目<br />";
                            //確認用↑↑↑↑↑↑↑↑
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
        #ツイートを形態素解析
        }
        
        // echo $judge[$j];
    // echo "----";


        /*
        計算した平均値を含んだjsonを作って保存
        */
        // $j_array = [
        //     'text' => $hash[$i]->text,
        //     'create_at' => $hash[$i]->created_at,
        //     'result' => "$result",
        // ];
        #json形式へ変換(文字化けとかしないように色々指定)
        // $json = json_encode($j_array , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        // file_put_contents("result".(string)$i.".json",$json); #jsonを保存

        // echo "============ENDFORRRRRR===============<br />";
                if ($result_f != 0) {
                    # code...
                    $result = $score/$np_num;
                    echo "======このツイートの平均: ",$result,"======<br />";
                }else{
                    echo "$i ツイート目には一致する単語はありません<br />";
                }
        
        echo "-----------------------------------------------------------------<br />";
    }

                if ($avg_f != 0) {
                    # code...
                    $final = $final_result/$final_count;
                    echo "======ヒットした", $avg_f, "ツイート全ての平均スコア: ",$final,"======<br />";
                }else{
                    echo "ヒットなし<br />";
                }


    @endphp
    


    {{-- @foreach ($hash as $value) {
        {{$value->text}}
        <br>
    @endforeach --}}

{{--     
    @foreach ($hash as $value) {
        {{$value->created_at}}
    @endforeach --}}


@php

$url = 'https://devomouua.cybozu.com/k/v1/record.json';
$headers = [
  'X-Cybozu-API-Token: WVM0OxyFErPOOuV8T4khJgPXkEMNZr081WNngESm',
  'Content-Type: application/json'
];

// $body = [
//   'app' => 5,
//   'record' => [
//     'text' => [
//         'value' => 'テストしてますテスト'
//     ],
//     'value' => [
//         'value' => '0.333'
//     ]
//   ]
// ];
// // JSONに変換
// $json = json_encode($body);

// // 初期化
// $curl = curl_init($url);

// curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
// curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
// curl_setopt($curl, CURLOPT_POSTFIELDS, $json);

// $response = curl_exec($curl);
// echo $response;

// curl_close($curl);


@endphp
@endsection