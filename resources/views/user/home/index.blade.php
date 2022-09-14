@extends('user.layouts.master')

@php
    $title = config('app.name', 'Laravel');
@endphp

@section('title')
    <title>{{$title}}</title>

    <meta name="keyword" content="Mau Bui Finance">
    <meta name="promotion" content="Mau Bui Finance">
    <meta name="Description" content="Mau Bui Finance - Khóa học về Crypto">

    <meta property="og:url" content="{{env('APP_URL')}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="Mau Bui Finance"/>
    <meta property="og:description" content="Mau Bui Finance - Khóa học về Crypto"/>
    <meta property="og:image" content="{{env('APP_URL') . optional(\App\Models\Logo::first())->image_path }}"/>

@endsection

@section('name')
    <h4 class="page-title">{{$title}}</h4>
@endsection

@section('css')

@endsection

@section('content')


@endsection

@section('js')

@endsection
