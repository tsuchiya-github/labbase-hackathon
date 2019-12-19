<!-- resources/views/index.blade.phpとして保存 -->

@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <div class="jumbotron">
        <h1>うっどんずラブ</h1>
        <p>本アプリは高松空港のお店に関する口コミを表示するアプリです!</p>
    </div>

    {{-- <div class="border border-info" style="padding:10px;">
        <h2>何について調べたいですか?</h2>    
    </div> --}}
    <br>


    @php

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    $result = json_decode($response, true);
    $shop = array_column($result["records"], "shop_name");
    $image = array_column($result["records"], "image");
    curl_close($curl);
    $post=[];
    $card=0;
    @endphp

    <div class="row row-eq-height" margin-bottom: 20rem;>
        @for ($i = 0; $i < 8; $i++)
            <div class="col-sm-6 col-md-3">
                <div class="card img-thumbnail">
                    <img class="card-img-top" src={{$image[$i]['value']}} alt="画像">
                    <div class="card-body px-2 py-3">
                        <h4 class="card-title">{{$shop[$i]['value']}}</h4>
                            {{-- <p class="card-text">{{$shop[$i]['value']}}に関する口コミを検索します</p> --}}
                            <form action="/judge" method="post" name=post_tag>
                                {{ csrf_field() }}                            
                                {{-- <p>いつからのツイートで検索しますか?：
                                    <input type="date" name="since">
                                </p> --}}
                                <p>何件のツイートで評価しますか?<br>(最小3，最大50)：
                                    <input type="number" name="count" min="3" max="50">
                                </p>
                                <input type="hidden" name="post_tag" value="{{$shop[$i]['value']}}">
                                <center><button type="submit" class="btn btn-success" id="btn">ツイート解析結果</button></center>
                            </form>
                        </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /.col-sm-6.col-md-3 -->
        @php
            $card++;
        @endphp    
        @if ($card%4==0)
            </div><!-- /.row -->
            <div class="row row-eq-height" margin-bottom: 20rem;>
        @endif
        @endfor
    </div>

    {{-- 以下テスト --}}
    <br>
    <div class="border border-success" style="padding:10px;">
        <h2>テスト用</h2>    
    </div>
    <br>
    
    <form action="/judge" method="post" name="post_test_tag">
        {{ csrf_field() }}
        {{-- <p>いつからのツイートで検索しますか?：
            <input type="date" name="since">
        </p> --}}
        <p>何件のツイートで評価しますか(最小3，最大100)?：
            <input type="number" name="count" min="3" max="100">
        </p>
        <p>ハッシュタグ(#抜きのテキストを入力):
        <input type="text" name="post_test_tag">
        <button type="submit" class="btn btn-success" id="btn">テスト用ツイート解析結果</button>
        </p>
    </form>
    </div>
    {{-- テストここまで --}}
@endsection

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
<script src="/js/blockUI/jquery.blockUI.js"></script>


<script type="text/javascript">
jQuery(function($){
  $("[id=btn]").click(function() {
    $.blockUI({
      message: 'しばらくお待ちください',
      css: {
        border: 'none',
        padding: '10px',
        backgroundColor: '#333',
        opacity: .5,
        color: '#fff'
      },
      overlayCSS: {
        backgroundColor: '#000',
        opacity: 0.6
      }
    });
    setTimeout($.unblockUI, 600000);
  });
}); 
</script>

<style>
h4{
  text-align: center;
}
</style>