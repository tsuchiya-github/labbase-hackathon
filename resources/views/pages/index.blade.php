<!-- resources/views/index.blade.phpとして保存 -->


@extends('layouts.app')


@section('title', 'Page Title')

@section('content')
    <div class="jumbotron">
        <h1>口コミをリアルタイムに表示するWebアプリ</h1>
        <p>本アプリは高松空港のお店に関する口コミを表示するアプリです!</p>
    </div>
{{-- @endsection

@section('content-main') --}}

    <div class="border border-info" style="padding:10px;">
        <h2>何について調べたいですか?</h2>    
    </div>
    <br>


    @php
    $url = 'https://devomouua.cybozu.com/k/v1/records.json?app=4';
    $headers = [
        'X-Cybozu-API-Token: A0W8Q7EKSibffANpUvHpn3j0GkpWr1CDGD4vdNJ6',
    //   'Content-Type: application/json'
    ];
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

    <form action="/judge" method="post" name="post_tag">
        {{ csrf_field() }}
        <p>いつからのツイートで検索しますか?：
            <input type="date" name="since">
        </p>
        <p>何件のツイートで評価しますか(最小5，最大50)?：
            <input type="number" name="count" min="3" max="20">
        </p>
        <p>テスト用(#抜きのテキストを入力):
        <input type="text" name="post_test_tag">
        <button type="submit" class="btn btn-success">テスト用ツイート解析結果</button>
        </p>

    <div class="row row-eq-height" margin-bottom: 20rem;>
        @for ($i = 0; $i < 8; $i++)
            <div class="col-sm-6 col-md-3">
                <div class="card img-thumbnail">
                    <img class="card-img-top" src={{$image[$i]['value']}} alt="画像">
                    <div class="card-body px-2 py-3">
                        <h5 class="card-title">{{$shop[$i]['value']}}</h5>
                            <p class="card-text">{{$shop[$i]['value']}}に関する口コミを検索します</p>
                            <input type="hidden" name="post_tag" value={{$shop[$i]['value']}}>
                            <center><button type="submit" class="btn btn-success">ツイート解析結果</button></center>
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

</form>

        {{-- @for ($i = 0; $i < 8; $i++)
            <div class="card border-info mb-3" style="max-width: 20rem;">
                <div class="card-header text-white bg-success">
                    <form action="/judge" method="post" name="post_tag"
>
                        {{ csrf_field() }}
                        <input type="hidden" name="post_tag" value={{$shop[$i]['value']}}>
                            <p>いつからのツイートで検索しますか：</p>
                        <input type="date" name="since">
                            <p>何件のツイートで評価しますか(最小5，最大50)：</p>
                        <input type="number" name="count" min="5" max="50">


                        <button type="submit" class="btn btn-success rounded-pill">{{$shop[$i]['value']}}</button>
                    </form>
                </div>
                <div class="card-block">
                    <p class="card-text">
                        {{$shop[$i]['value']}}に関する口コミを検索します
                    </p>
                </div>
            </div>
        @endfor
    
 --}}

    


    {{-- @foreach ($test as $item)
        {{$item[0]->shop_name}}
    @endforeach --}}


        {{-- @if(count($tags) > 0)
        @foreach($tags as $tag)
            <div class="card .bg-success">
            <a href="/judge/tag?tag={{$tag->tag}}">{{$tag->ID}}:{{$tag->tag}}</a>
            </div>
        @endforeach
        <center>
        {{$tags->links()}}
        </center>
    @else
        <p>No posts found</p>
    @endif --}}

@endsection

{{-- @section('content-sub')
    <p class="bg-primary text-left">何か</p>

@endsection --}}
