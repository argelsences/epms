<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <!-- some layouts on these pages are inspired by Attendize, an Open-source ticket selling and event management platform https://www.attendize.com/ -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ __('Event Publication and Poster Management System (EPPMS)') }}</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!-- Open Graph data -->
    <meta property="og:title" content="{{{$title}}}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url('/d/' . $url) }}" />
    <meta property="og:image" content="{{ url( $logo_path ) }}" />
    <meta property="og:description" content="{{{Str::words(strip_tags('An event publication and poster generation system')), 20}}}" />
    <meta property="og:site_name" content="EPPMS" />
    
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <!-- Jquery? -->
    <script src="{{ asset('material') }}/js/core/jquery.min.js"></script>
    <!-- include default laravel JS and SASS -->
    <!--<script src="{{ asset('/js/manifest.js') }}" defer></script>
    <script src="{{ asset('/js/vendor.js') }}" defer></script>-->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/front.css') }}" rel="stylesheet">
    @yield('head')
    </head>
    <body>
      <div id="app">
        <!--<div id="department_page_wrap">-->
          @auth()
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
          @endauth
          
          @yield('content') 
          @yield('footer')
          <!--
          <a href="#intro" style="display:none;" class="totop">
            <i class="ico-angle-up"></i>
            <span style="font-size:11px;">TOTOP</span>
          </a>
          -->
        <!--</div>-->   
      </div>
      
      @stack('js')
    </body>
</html>