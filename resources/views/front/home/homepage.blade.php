@extends('layouts.app_front', [
  'title' => Config::get('app.name'),
  'url' => '/',
  'logo_path' => '/' ,
  ])

@section('title')
  {{ Config::get('app.name') }}
@endsection

@section('head')
     <style>
          body { background-color: {{$objSettings['bg_color']}} !important; }
          section#intro {
               background-color: {{$objSettings['header_bg_color']}} !important;
               color: {{ $objSettings['text_color'] }} !important;
          }
          .event-list > li > time {
               color: {{$objSettings['text_color']}};
               background-color: {{$objSettings['header_bg_color']}};
          }

     </style>
     {{--
     @if($department->google_analytics_code)
          @include('Public.Partials.ga', ['analyticsCode' => $department->google_analytics_code])
     @endif
     --}}
@endsection

@section('content')
     @include('front.home.partials.header')
     {{--
     @include('front.home.partials.body')
     @include('front.home.partials.footer')
     --}}
@endsection