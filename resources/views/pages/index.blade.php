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
    // var_dump($result["records"]);
    $test = array_column($result["records"], "shop_name");

    // var_dump($test[0]['value']);
    curl_close($curl);
    @endphp

    @php
        $post=[];
    @endphp

        @for ($i = 0; $i < 8; $i++)
            <div class="card border-info mb-3" style="max-width: 20rem;">
                <div class="card-header text-white bg-success">
                    <form action="/judge" method="post" name="post_tag"
>
                        {{ csrf_field() }}
                        <input type="hidden" name="post_tag" value={{$test[$i]['value']}}>
                            <p>いつからのツイートで検索しますか：</p>
                        <input type="date" name="since">
                            <p>何件のツイートで評価しますか(最小5，最大50)：</p>
                        <input type="number" name="count" min="5" max="50">


                        <button type="submit" class="btn btn-success rounded-pill">{{$test[$i]['value']}}</button>
                    </form>
                </div>
                <div class="card-block">
                    <p class="card-text">
                        {{$test[$i]['value']}}に関する口コミを検索します
                    </p>
                </div>
            </div>
        @endfor
    


    


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
