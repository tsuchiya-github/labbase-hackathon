<!-- resources/views/review.blade.phpとして保存 -->

@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>ここはメインのサイドバーに追加される</p>
@endsection

@section('content')
<p>{{$data}}</p>

@foreach((array)$data as $item)
    {{$data}}
@endforeach
@endsection