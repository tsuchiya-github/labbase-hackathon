<!-- resources/views/index.blade.phpとして保存 -->

@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <div class="jumbotron">
        <h1>口コミをリアルタイムに表示するWebアプリ</h1>
        <p>本アプリは高松空港とその周辺のお店に関する口コミを表示するアプリです!</p>
    </div>
@endsection

@section('content-main')

    <div class="border border-info" style="padding:10px;">
        <h2>何について調べたいですか?<small class="text-muted">(複数選択可)</small></h2>    
    </div>
    <br>
    <form action="/review" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <select class="form-control" id="select_tag" name="select_tag" multiple required>
                <option disabled selected value>選択してください</option>
                <option value="うどん">うどん</option>
                <option value="骨付鳥">骨付鳥</option>
                <option value="お土産">お土産</option>
                <option value="観光地">観光地</option>
            </select>
            <br>
            <button type="submit" id="button_tag" class="btn btn-info pull-center" value="submit">決定する</button>
        </div>
    </form>
@endsection

@section('content-sub')
    <p class="bg-primary text-left">グリッド(右）</p>

@endsection
