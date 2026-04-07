<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
     <meta name="description"
          content="Abdul Majid - {{config('global.project_shortname')}}">
    <meta name="keywords"
          content="Abdul Majid - {{config('global.project_shortname')}}">
    <meta name="author" content="Abdul Majid">
    <meta name="description" content="Dashboard - Abdu; Majid">
    <meta name="keywords" content="Dashboard - Abdu; Majid">
    <meta name="author" content="abdulmajid.khaliq@aku.edu">
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard -{{config('global.project_name')}}</title>

    @include('layouts.simple.css')
    @yield('style')
</head>
<style type="text/css">
    .customizer-toggle {display: none!important;}
    .bg-purple{background:#4e7ac7;}
    body.vertical-layout[data-color=bg-info] .content-wrapper-before, body.vertical-layout[data-color=bg-info] .navbar-container {
        background-color: #4e7ac7!important;
    }
    .main-menu.menu-light .navigation > li.active > a {background: #4e7ac7;
    }
    .text-info {
        color: #4e7ac7!important;
    }
    html body a {
        color: #4e7ac7;
    }
    html body .content .content-wrapper {
        padding: 0rem;
    }
</style>
<body class="vertical-layout vertical-menu-modern 2-columns   fixed-navbar " data-open="click"
      data-menu="vertical-menu-modern" data-color="bg-info" data-col="2-columns">


<div class="spinner-border " id="loader">
    <span class="sr-only">Loading...</span>
</div>
<!-- Page Header Start  -->
    @include('layouts.simple.header')
<!-- Page Header Ends  -->

<!-- Page Sidebar Start-->
    @include('layouts.simple.sidebar')
<!-- Page Sidebar END-->

<!-- Page content Start-->
    @yield('content')
<!-- Page content END-->


<!-- Page footer Start-->
    @include('layouts.simple.footer')
<!-- Page footer END-->



    </div>
</div>
<!-- latest jquery-->
@include('layouts.simple.script')
<!-- Plugin used-->
@include('layouts.simple.resetPwd')

</body>
</html>
