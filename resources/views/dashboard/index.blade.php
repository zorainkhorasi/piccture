@extends('layouts.simple.master')
@section('title', 'Default')
@section('css')
@endsection
@section('style')

@endsection
@section('content')
    <!-- BEGIN: Content-->
    <link rel="stylesheet" type="text/css"
          href="{{ asset(config('global.asset_path') . '/css/aos_animation/aos.css') }}">
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-wrapper-before"></div>
            <div class="content-header row">
                <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Dashboard</h3>

                </div>
            </div>
            <div class="content-body">
                <section id="ordering">
                    <div class="row" style="margin-bottom: 8px;">
                        <div class="col-md-12 col-sm-6 col-lg-12">
                            <div class="wrapper pull-right">



                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card coolsky text-center text-success" >
                                <div class="card-content">
                                    <div class="card-body">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </div>
    </div>
    </section>
    </div>
    </div>
    </div>
    <!-- END: Content-->
    <!-- Modal ----->
@endsection

