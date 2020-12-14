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
          <!--@yield('content')

          {{-- Push for sticky footer--}}-->
          @include('front.event.partials.header-section')
          @include('front.event.partials.ticket-section')
          @include('front.event.partials.description-section')
          @include('front.event.partials.share-section')
          @include('front.event.partials.map-section')
          @include('front.event.partials.organiser-section')

          @stack('footer')
     </div>

     {{-- Sticky Footer--}}
     {{--
     @yield('footer')

     <a href="#intro" style="display:none;" class="totop"><i class="ico-angle-up"></i>
          <span style="font-size:11px;">@lang("basic.TOP")</span></a>

     @include("Shared.Partials.LangScript")
     {!!Html::script(config('attendize.cdn_url_static_assets').'/assets/javascript/frontend.js')!!}


     @if(isset($secondsToExpire))
     <script>if($('#countdown')) {setCountdown($('#countdown'), {{$secondsToExpire}});}</script>
     @endif

     @include('Shared.Partials.GlobalFooterJS')
     --}}
@endsection