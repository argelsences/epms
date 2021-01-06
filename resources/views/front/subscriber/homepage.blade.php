@extends('layouts.app_front', [
  'title' => '',
  'url' => '/',
  'logo_path' => '/' ,
  ])

@section('title')
  {{ Config::get('app.name') }}
@endsection

@section('head')
@endsection

@section('content')
    @include('front.subscriber.partials.header')
    @include('front.subscriber.partials.unsubscribe')
@endsection