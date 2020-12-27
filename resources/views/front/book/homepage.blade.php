@extends('layouts.app_front', [
  'title' => $department->name,
  'url' => $department->url,
  'logo_path' => ($department->logo_path) ? $department->logo_path : '/' ,
  ])

@section('title')
  {{$department->name}}
@endsection

@section('head')
     <style>
          body { background-color: {{$department->page_bg_color ?? $objSettings['bg_color']}} !important; }
          section#intro {
               background-color: {{$department->page_header_bg_color ?? $objSettings['header_bg_color']}} !important;
               color: {{$department->page_text_color ?? $objSettings['text_color']}} !important;
          }
          .event-list > li > time {
               color: {{$department->page_text_color ?? $objSettings['text_color']}};
               background-color: {{$department->page_header_bg_color ?? $objSettings['header_bg_color']}};
          }

     </style>
     @if($department->google_analytics_code)
          @include('Public.Partials.ga', ['analyticsCode' => $department->google_analytics_code])
     @endif
@endsection

@section('content')
     <div id="event_page_wrap" vocab="http://schema.org/" typeof="Event">

          @include('front.event.partials.header-section')
          @include('front.event.partials.share-section')
          @include('front.book.partials.view-order-section')
          {{--
               @include('front.book.partials.event-footer-section')
          --}}
     </div>
    
@stop