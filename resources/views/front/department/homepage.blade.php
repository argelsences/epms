@extends('layouts.app_front', [
  'title' => $department->name,
  'activePage' => 'user-management', 
  'titlePage' => __('User Management'),
  'url' => $department->url,
  'logo_path' => ($department->logo_path) ? $department->logo_path : '/' ,
  ])

@section('title')
  {{$department->name}}
@endsection

@section('head')
     <style>
          body { background-color: {{$department->page_bg_color}} !important; }
          section#intro {
               background-color: {{$department->page_header_bg_color}} !important;
               color: {{$department->page_text_color}} !important;
          }
          .event-list > li > time {
               color: {{$department->page_text_color}};
               background-color: {{$department->page_header_bg_color}};
          }

     </style>
     @if($department->google_analytics_code)
          @include('Public.Partials.ga', ['analyticsCode' => $department->google_analytics_code])
     @endif
@endsection

@section('content')
  <!--<div class="container" style="height: auto;">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-8">
            <h1 class="text-white text-center">{{ __('Welcome to Material Dashboard FREE Laravel Live Preview.') }}</h1>
        </div>
    </div>
  </div>-->
  @include('front.department.partials.header')
@endsection