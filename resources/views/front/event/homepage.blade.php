@extends('layouts.app_front', [
  'title' => $department->name,
  'url' => $department->url,
  'logo_path' => ($department->logo_path) ? $department->logo_path : '/' ,
  ])

@section('title')
  {{$department->name}}
@endsection

@section('head')
     @if($department->google_tag_manager_code)
          @include('front.shared.partials.gtm-head', ['tagManager' => $department->google_tag_manager_code])
     @endif
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
          @include('front.shared.partials.ga', ['analyticsCode' => $department->google_analytics_code])
     @endif
@endsection

@section('content')
     @if($department->google_tag_manager_code)    
          @include('front.shared.partials.gtm-body', ['tagManager' => $department->google_tag_manager_code])
     @endif
     <div id="event_page_wrap" vocab="http://schema.org/" typeof="Event">
          <!--@yield('content')

          {{-- Push for sticky footer--}}-->
          @include('front.event.partials.header-section')
          @include('front.event.partials.ticket-section')
          @include('front.event.partials.description-section')
          @include('front.event.partials.map-section')
          @include('front.event.partials.share-section')
          @include('front.event.partials.organiser-section')
          @include('front.event.partials.subscribe')

     </div>

     
@endsection

@section('footer')
     @include('front.shared.partials.event-footer')
@endsection