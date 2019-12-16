<!-- resources/views/review.blade.phpとして保存 -->

@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>ここはメインのサイドバーに追加される</p>
@endsection

@section('content-main')

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


    #jsonをstringで読み込んで文字コード合わせてjsonの形式にする
    for($tweet_num=1 ;  $tweet_num<=3/*ツイートの数*/ ; $tweet_num++){
        $hibi = file_get_contents("./json/test".(string)$tweet_num.".json");
        $hibi = mb_convert_encoding($hibi, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        #var_dump($hibi);
        $arr = json_decode($hibi,true);
        echo "<br />";
        //確認用↓↓↓↓↓↓↓↓
        dump($arr);
        echo "<br />ツイートの長さは: ", mb_strlen($arr["test"]["text"]),"<br />";
        //確認用↑↑↑↑↑↑↑↑
        $score = 0;
        $np_num = 0;
        /*
        対応表の中の単語の数だけ繰り返しする
        ツイートの中で単語表の言葉があればtrueの処理,なければなんもなし
        */
        for($tango=0; $tango<(count($negaposi)); $tango++){
            if (mb_strpos($arr["test"]["text"],$negaposi[$tango][0]) !== false){
                //含まれている場合
                //確認用↓↓↓↓↓↓↓↓
                echo "-----",$negaposi[$tango][0],",",$negaposi[$tango][1],"-----<br />";
                echo "対象から最後まで: ", strstr($arr["test"]["text"],$negaposi[$tango][0]),"<br />";
                echo "位置は: ", mb_strpos($arr["test"]["text"],$negaposi[$tango][0]),"<br />";
                echo "スコアは: ",$negaposi[$tango][3],"<br >";
                //確認用↑↑↑↑↑↑↑↑
                
                $score = $score + (float)$negaposi[$tango][3]; #スコア加算
                $np_num++; #平均算出用


                #まだ同じ単語があるか判定
                $pos = mb_strpos($arr["test"]["text"],$negaposi[$tango][0]);#感情文字のある場所
                $np_arr = strstr($arr["test"]["text"],$negaposi[$tango][0]);#対象から最後まで
                $lentan = mb_strlen($negaposi[$tango][0]); #感情単語の長さ
                $strlen = mb_strlen($np_arr); #切り出したあとの長さ
                $aaanp_arr = mb_substr($arr["test"]["text"],($pos+$lentan),($strlen-$lentan));#対象+単語分から最後まで
                $tan_num = 0; #単語の数
                while(mb_strpos($aaanp_arr,$negaposi[$tango][0]) !== false){
                    $tan_num++;
                    //確認用↓↓↓↓↓↓↓↓
                    echo "$aaanp_arr <br />";
                    echo $negaposi[$tango][0],"(",$negaposi[$tango][1],")は" ,$tan_num+1,"個目<br />";
                    //確認用↑↑↑↑↑↑↑↑
                    $pos2 = mb_strpos($aaanp_arr,$negaposi[$tango][0]);
                    $np_arr2 = strstr($aaanp_arr,$negaposi[$tango][0]);#対象から最後まで
                    $aaanp_arr = mb_substr($aaanp_arr,($pos2+$lentan),($strlen-1));#対象+単語分から最後まで
                    
                    $score = $score + (float)$negaposi[$tango][3]; #スコア加算
                    $np_num++; #平均算出用
                }

            }else{
                //含まれていない場合　

            }

        }
        $result = $score/$np_num;
        echo "======平均: ",$result,"======<br />";

    

        /*
        計算した平均値を含んだjsonを作って保存
        */
        $j_array = [
            'text' => $arr["test"]["text"],
            'create_at' => $arr["test"]["create_at"],
            "url" => $arr["test"]["url"],
            'result' => "$result",
        ];
        #json形式へ変換(文字化けとかしないように色々指定)
        $json = json_encode($j_array , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        file_put_contents("result".(string)$tweet_num.".json",$json); #jsonを保存

        echo "============ENDFORRRRRR===============<br />";
    }
    @endphp

@endsection