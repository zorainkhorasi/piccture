@extends('layouts.authentication.master')
@section('title', 'Login')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
    <style type="text/css">
        .text_center_ {
            text-align: center;
            top: 30%;
            position: relative;
        }

        .color_white {
            color: white;
        }

        .theme_color {
            color: #8a1a77;
        }

        .login-card {

            background-color: #4e7ac7;
        }


    </style>
    <link rel="stylesheet" type="text/css" href="{{asset(config('global.asset_path').'/css/aos_animation/aos.css')}}">
    <div class="container-fluid p-0">
        <div class="row m-0">

            <div class="col-8 l" style="">
                <div class="text_center_" data-aos="fade-right" data-aos-duration="2000">


                    <h6 class="text-info">{{config('global.project_name')}} (PREPARE)</h6>
                    <h6 class="text-info">Institute of Global Health & Development (IGHD), </h6>
                    <h6 class="text-info">Aga Khan University, Karachi, Pakistan </h6>
                    <img src="{{asset(config('global.asset_path_prepare').'/images/logo.png')}}" class="rounded-circle"
                         style="width:30%;">
                </div>
            </div>
            <div class="col-4 p-0">
                <div class="login-card">
                    <div>
                        <div>
                            <a class="logo" href="{{ url('index') }}">
                                <!-- <h3 class="txt-primary "></h3>  -->
                            </a>
                        </div>
                        <div class="login-main" data-aos="fade-left" data-aos-duration="2000">
                            <form method="POST" class="theme-form" action="{{ route('login') }}">
                                @csrf
                                <h4 class="text-success">Sign in to account</h4>
                                <p>Enter your email & password to login</p>
                                <!-- Session Status -->
                                <x-auth-session-status class="mb-4 txt-danger" :status="session('status')"/>
                                <!-- Validation Errors -->
                                <x-auth-validation-errors class="mb-4 txt-danger" :errors="$errors"/>

                                <div class="form-group">
                                    <label class="col-form-label" for="email">Email Address</label>
                                    <input class="form-control" type="email" name="email" id="email"
                                           required="" autofocus value="" placeholder="test@aku.edu">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="password">Password</label>
                                    <input class="form-control" id="password" type="password"
                                           name="password" required=""
                                           placeholder="*********" value="" autocomplete="current-password">
                                    <div class="show-hide"><span class="show"></span></div>
                                </div>
                                <input type="hidden" name="recaptcha" id="recaptcha">
                                <div class="form-group mb-0">
                                    <div class="checkbox p-0">
                                        <input id="remember_me" type="checkbox" name="remember">
                                        <label class="text-muted" for="remember_me">{{ __('Remember me') }}</label>
                                    </div>
                                    <!-- @if (Route::has('password.request'))
                                        <a class="link" href="{{ route('password.request') }}"> {{ __('Forgot your password?') }}</a>

                                    @endif -->
                                    <button class="btn btn-info w-100" type="submit"
                                    >Sign in
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset(config('global.asset_path').'/js/aos_animation/aos.js')}}"></script>
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
    <script>

        grecaptcha.ready(function () {
            grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: 'contact'}).then(function (token) {
                if (token) {
                    document.getElementById('recaptcha').value = token;
                }
            });
        });


    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            AOS.init();
        });
    </script>
@endsection
