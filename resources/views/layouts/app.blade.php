<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Event Publication and Poster Management System (EPPMS)') }}</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <!--//<link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />-->
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <!--//<link href="{{ asset('material') }}/demo/demo.css" rel="stylesheet" />-->
    <!-- Jquery? -->
    <script src="{{ asset('material') }}/js/core/jquery.min.js"></script>

    <!-- include default laravel JS and SASS -->
    <!--<script src="{{ asset('/js/manifest.js') }}" defer></script>
    <script src="{{ asset('/js/vendor.js') }}" defer></script>-->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!--<script src="{{ asset('js/drawerJs.standalone.js') }}" ></script>-->
    <!--<link href="{{-- mix('css/drawerJs.css') --}}" rel="stylesheet">-->
    
    
    </head>
    <body class="{{ $class ?? '' }}">
      <div id="app">
          @auth()
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
              <admin-template></admin-template>
          @endauth
          @guest()
              @include('layouts.page_templates.guest')
          @endguest
      </div>     
      <!--<script src="{{-- mix('js/drawerJs.js') --}}" ></script>-->
      @stack('js')
    </body>
</html>