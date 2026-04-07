@extends('layouts.simple.master')
@section('title',  trans('lang.pages_main_heading')  )

@section('css')

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset(config('global.asset_path').'/css/vendors/select2.css')}}">
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.pages_main_heading') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ trans('lang.pages_main_heading') }}</li>
@endsection

@section('content')
    @php
        $colors = array('#8a1a77', '#e78400', '#058bff', '#40943b', '#943b3b', '#3b6a94', '#943b90', '#758414',
                                           '#841425', 'orange', 'black', '#8a1a77', 'antiquewhite', 'aliceblue', '#943b3b', '#3b6a94',
                                           'info', 'danger', 'mycolor1', 'success', 'primary', 'warning', 'mycolor2', 'mycolor3',
                                           'primary', 'warning', 'danger', 'success', 'info', 'mycolor1', 'mycolor2', 'mycolor3',
                                           'danger', 'success', 'mycolor3', 'mycolor1', 'info', 'mycolor2', 'primary', 'warning',
                                           'info', 'danger', 'mycolor1', 'success', 'primary', 'warning', 'mycolor2', 'mycolor3');
    @endphp
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-wrapper-before"></div>
            <div class="content-header row">
                <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Survey Status</h3>

                    </div>
                </div>
                <div class="content-header-right col-md-4 col-12 d-block d-md-none"><a
                        class="btn btn-warning btn-min-width float-md-right box-shadow-4 mr-1 mb-1"
                        href="#"><i class="ft-mail"></i> Survey Status</a>
                </div>
            </div>
            <div class="content-body">
                <section id="ordering">
                    <div class="row">

                        <div class="col-lg-3 col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-end">
                                    <h4 class="card-title">Total Clusters</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body py-0">
                                        <div class="row">
                                            <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                                <h1 class="font-large-2 text-bold-700 mt-2 mb-0">
                                                    @if (isset($data['totalcluster']) && $data['totalcluster'] != ''&& $data['totalcluster'] != '0')
                                                        {{$data['totalcluster']}}
                                                    @else
                                                        @php
                                                            $data['totalcluster']=100;
                                                        @endphp
                                                        {{$data['totalcluster']}}
                                                    @endif
                                                    <small>Clusters</small>
                                            </div>
                                            <div class="col-sm-12 col-12 d-flex justify-content-center">
                                                <div id="total_cluster" class="mt-75"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body completed_clusters">
                                        @php $s=0; @endphp
                                        @if (isset($data['total']) && $data['total'] != '')
                                            @foreach ($data['total'] as $keys=>$total)
                                                <a href="{{route('datacollection_detail')}}/t/{{$keys}}"
                                                   target="_blank">
                                                    <div class="media mb-0">
                                                        <div class="media-body"><h6
                                                                class="text-start"><span
                                                                    class="font-primary"
                                                                    style="color:{{$colors[$s]}};">{{$total['district_name']}}</span>
                                                            </h6>
                                                        </div>
                                                        <p class="text-end">{{$total['count']}}</p>
                                                    </div>
                                                </a>
                                                <div class="progress"
                                                     style=" height: 10px; background-color:{{$colors[$s]}};">
                                                    <div
                                                        class="progress-bar-animated mysmall_text"
                                                        role="progressbar"
                                                        style="width: 100%;color:white;"
                                                        aria-valuenow="{{$total['count']}}"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100">100%
                                                    </div>
                                                </div>
                                                    <?php $s++; ?>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-end">
                                    <h4 class="card-title">Completed</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body py-0">
                                        <div class="row">
                                            <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                                <h1 class="font-large-2 text-bold-700 mt-2 mb-0">
                                                    @php $perc=0;@endphp
                                                    @if (isset($data['total_completed']) && $data['total_completed'] != '')
                                                        @php
                                                            $perc_cal = ($data['total_completed'] / $data['totalcluster']) * 100;
                                                            $perc=(isset($perc_cal) && $perc_cal!=''?$perc_cal:'0');
                                                        @endphp
                                                        {{$data['total_completed']}}
                                                    @endif
                                                    <input type="hidden" id="completed_hidden"
                                                           value="{{number_format($perc,1)}}">
                                                    <small>Completed</small>
                                            </div>
                                            <div class="col-sm-12 col-12 d-flex justify-content-center">
                                                <div id="completed_cluster" class="mt-75"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body completed_clusters">
                                        @php
                                            $s=0;
                                        @endphp
                                        @if (isset($data['completed']) && $data['completed'] != '')
                                            @foreach ($data['completed'] as $keys=>$completed)
                                                @php
                                                    $t=(isset($data['total'][$keys]['count']) && $data['total'][$keys]['count']!=''?$data['total'][$keys]['count']:'0');
                                                    $d=(isset($completed['count']) && $completed['count']!=''?$completed['count']:'0');
                                                    $perc_cal = ($d / $t) * 100;
                                                    $perc=(isset($perc_cal) && $perc_cal!='' && $perc_cal!='0'?number_format($perc_cal,1):'0');
                                                @endphp

                                                <a href="{{route('datacollection_detail')}}/c/{{$keys}}"
                                                   target="_blank">
                                                    <div class="media mb-0">
                                                        <div class="media-body"><h6 class=" text-start"><span
                                                                    class="font-primary" style="color:{{$colors[$s]}};">{{$completed['district_name']}}</span>
                                                            </h6>
                                                        </div>
                                                        <p class="text-end">{{$completed['count']}} ({{$perc}}%)</p>
                                                    </div>
                                                </a>
                                                <div class="progress" style="height: 10px">
                                                    <div class="progress-bar-animated mysmall_text bg-{{$colors[$s]}}"
                                                         role="progressbar"
                                                         style="width: {{number_format($perc,0)}}%; background:
                                                          {{$colors[$s]}}; color:white;"
                                                         aria-valuenow="{{$completed['count']}}" aria-valuemin="0"
                                                         aria-valuemax="100">{{$perc}}%
                                                    </div>
                                                </div>

                                                    <?php $s++; ?>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-end">
                                    <h4 class="card-title">In Progress</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body py-0">
                                        <div class="row">
                                            <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                                <h1 class="font-large-2 text-bold-700 mt-2 mb-0">
                                                    @if (isset($data['total_ip']) && $data['total_ip'] != '')
                                                        @php
                                                            $perc_cal = ($data['total_ip'] / $data['totalcluster']) * 100;
                                                            $perc=(isset($perc_cal) && $perc_cal!=''?$perc_cal:'0');
                                                        @endphp
                                                        {{$data['total_ip']}}
                                                    @endif
                                                    <input type="hidden" id="ip_hidden"
                                                           value="{{number_format($perc,1)}}">
                                                    <small>In Progress</small>
                                            </div>
                                            <div class="col-sm-12 col-12 d-flex justify-content-center">
                                                <div id="ip_cluster" class="mt-75"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body completed_clusters">
                                        @php
                                            $s=0;
                                        @endphp
                                        @if (isset($data['ip']) && $data['ip'] != '')
                                            @foreach ($data['ip'] as $keys=>$ip)
                                                @php

                                                    $t=(isset($data['total'][$keys]['count']) && $data['total'][$keys]['count']!=''?$data['total'][$keys]['count']:'0');
                                                    $d=(isset($ip['count']) && $ip['count']!=''?$ip['count']:'0');
                                                    $perc_cal = ($d / $t) * 100;
                                                    $perc=(isset($perc_cal) && $perc_cal!='' && $perc_cal!='0'?number_format($perc_cal,1):'0');
                                                @endphp

                                                    <a href="{{route('datacollection_detail')}}/i/{{$keys}}" target="_blank">
                                                        <div class="media mb-0">
                                                            <div class="media-body"><h6 class=" text-start"><span
                                                                        class="font-primary" style="color:{{$colors[$s]}};">{{$ip['district_name']}}</span></h6>
                                                            </div>
                                                            <p class="text-end">{{$ip['count']}} ({{$perc}}%)</p>
                                                        </div>
                                                    </a>
                                                <div class="progress" style="height: 10px">
                                                    <div class="progress-bar-animated mysmall_text bg-{{$colors[$s]}}"
                                                         role="progressbar"
                                                         style="width: {{number_format($perc,0)}}%; background:
                                                          {{$colors[$s]}};color:white;"
                                                         aria-valuenow="{{$ip['count']}}" aria-valuemin="0"
                                                         aria-valuemax="100">{{$perc}}%
                                                    </div>
                                                </div>
                                                <?php $s++;?>

                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-3 col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-end">
                                    <h4 class="card-title">Remaining</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body py-0">
                                        <div class="row">
                                            <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                                <h1 class="font-large-2 text-bold-700 mt-2 mb-0">
                                                    @if (isset($data['total_r']) && $data['total_r'] != '')
                                                        @php
                                                            $perc_cal = ($data['total_r'] / $data['totalcluster']) * 100;
                                                            $perc=(isset($perc_cal) && $perc_cal!=''?$perc_cal:'0');
                                                        @endphp
                                                        {{$data['total_r']}}
                                                    @endif
                                                    <input type="hidden" id="r_hidden"
                                                           value="{{number_format($perc,1)}}">
                                                    <small>Remaining</small>
                                            </div>
                                            <div class="col-sm-12 col-12 d-flex justify-content-center">
                                                <div id="r_cluster" class="mt-75"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body completed_clusters">
                                        @php $s=0; @endphp
                                        @if (isset($data['r']) && $data['r'] != '')
                                            @foreach ($data['r'] as $keys=>$r)
                                                @php

                                                    $t=(isset($data['total'][$keys]['count']) && $data['total'][$keys]['count']!=''?$data['total'][$keys]['count']:'0');
                                                    $d=(isset($r['count']) && $r['count']!=''?$r['count']:'0');
                                                    $perc_cal = ($d / $t) * 100;
                                                    $perc=(isset($perc_cal) && $perc_cal!='' && $perc_cal!='0'?number_format($perc_cal,1):'0');
                                                @endphp

                                                    <a href="{{route('datacollection_detail')}}/r/{{$keys}}" target="_blank">
                                                        <div class="media mb-0">
                                                            <div class="media-body"><h6 class=" text-start"><span
                                                                        class="font-primary" style="color:{{$colors[$s]}};">{{$r['district_name']}}</span></h6>
                                                            </div>
                                                            <p class="text-end">{{$r['count']}} ({{$perc}}%)</p>
                                                        </div>
                                                    </a>
                                                <div class="progress" style="height: 10px">
                                                    <div class="progress-bar-animated mysmall_text bg-{{$colors[$s]}}"
                                                         role="progressbar"
                                                         style="width: {{number_format($perc,0)}}%; background:
                                                          {{$colors[$s]}};color:white;"
                                                         aria-valuenow="{{$r['count']}}" aria-valuemin="0"
                                                         aria-valuemax="100">{{$perc}}%
                                                    </div>
                                                </div>

                                                <?php $s++;?>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

@endsection

@section('script')

    <script src="{{asset(config('global.asset_path').'/js/chart/apex-chart/apex-chart.js')}}"
            type="text/javascript"></script>
    <script src="{{asset(config('global.asset_path').'/js/custom-card/custom-card.js')}}"
            type="text/javascript"></script>
    <script src="{{asset(config('global.asset_path').'/js/clipboard/clipboard.min.js')}}"
            type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            total_chart();
            completed_chart();
            ip_chart();
            r_chart();
        });

        function total_chart() {
            var options4 = {
                series: [100],
                chart: {
                    height: 350,
                    type: 'radialBar',
                    offsetY: -10,
                },

                plotOptions: {
                    radialBar: {
                        startAngle: -135,
                        endAngle: 135,
                        inverseOrder: true,
                        hollow: {
                            margin: 5,
                            size: '60%',
                            image: '{{asset(config('global.asset_path').'/images/dashboard-2/radial-image.png')}}',
                            imageWidth: 140,
                            imageHeight: 140,
                            imageClipped: false,
                        },
                        track: {
                            opacity: 0.4,
                            colors: '#7366ff'
                        },
                        dataLabels: {
                            enabled: false,
                            enabledOnSeries: undefined,
                            formatter: function (val, opts) {
                                return val + "%"
                            },
                            textAnchor: 'middle',
                            distributed: false,
                            offsetX: 0,
                            offsetY: 0,

                            style: {
                                fontSize: '14px',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fill: ['#2b2b2b'],

                            },
                        },
                    }
                },

                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        shadeIntensity: 0.15,
                        inverseColors: false,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100],
                        gradientToColors: ['#a927f9'],
                        type: 'horizontal'
                    },
                },
                stroke: {
                    dashArray: 15,
                    strokecolor: ['#ffffff']
                },

                labels: ['Total'],
                colors: ['#7366ff'],
            };
            var chart4 = new ApexCharts(document.querySelector("#total_cluster"),
                options4
            );
            chart4.render();
        }

        function completed_chart() {
            var completed_hidden = $('#completed_hidden').val();
            if (completed_hidden == '' || completed_hidden == undefined) {
                completed_hidden = 0;
            }
            var options = {
                series: [completed_hidden],
                chart: {
                    height: 350,
                    type: 'radialBar',
                    offsetY: -10,
                },

                plotOptions: {
                    radialBar: {
                        startAngle: -135,
                        endAngle: 135,
                        inverseOrder: true,
                        hollow: {
                            margin: 5,
                            size: '60%',
                            image: '{{asset(config('global.asset_path').'/images/dashboard-2/radial-image.png')}}',
                            imageWidth: 140,
                            imageHeight: 140,
                            imageClipped: false,
                        },
                        track: {
                            opacity: 0.4,
                            colors: '#f73164'
                        },
                        dataLabels: {
                            enabled: false,
                            enabledOnSeries: undefined,
                            formatter: function (val, opts) {
                                return val + "%"
                            },
                            textAnchor: 'middle',
                            distributed: false,
                            offsetX: 0,
                            offsetY: 0,

                            style: {
                                fontSize: '14px',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fill: ['#7dafb7'],

                            },
                        },
                    }
                },

                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        shadeIntensity: 0.15,
                        inverseColors: false,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100],
                        gradientToColors: ['#7dafb7'],
                        type: 'horizontal'
                    },
                },
                stroke: {
                    dashArray: 15,
                    strokecolor: ['#ffffff']
                },

                labels: ['Completed'],
                colors: ['green'],
            };
            var chart = new ApexCharts(document.querySelector("#completed_cluster"),
                options
            );
            chart.render();
        }

        function ip_chart() {
            var ip_hidden = $('#ip_hidden').val();
            if (ip_hidden == '' || ip_hidden == undefined) {
                ip_hidden = 0;
            }
            var options = {
                series: [ip_hidden],
                chart: {
                    height: 350,
                    type: 'radialBar',
                    offsetY: -10,
                },

                plotOptions: {
                    radialBar: {
                        startAngle: -135,
                        endAngle: 135,
                        inverseOrder: true,
                        hollow: {
                            margin: 5,
                            size: '60%',
                            image: '{{asset(config('global.asset_path').'/images/dashboard-2/radial-image.png')}}',
                            imageWidth: 140,
                            imageHeight: 140,
                            imageClipped: false,
                        },
                        track: {
                            opacity: 0.4,
                            colors: '#f73164'
                        },
                        dataLabels: {
                            enabled: false,
                            enabledOnSeries: undefined,
                            formatter: function (val, opts) {
                                return val + "%"
                            },
                            textAnchor: 'middle',
                            distributed: false,
                            offsetX: 0,
                            offsetY: 0,

                            style: {
                                fontSize: '14px',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fill: ['#efe3a5'],
                            },
                        },
                    }
                },

                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        shadeIntensity: 0.15,
                        inverseColors: false,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100],
                        gradientToColors: ['#efe3a5'],
                        type: 'horizontal'
                    },
                },
                stroke: {
                    dashArray: 15,
                    strokecolor: ['#ffffff']
                },

                labels: ['InProgress'],
                colors: ['#f8d62b'],
            };
            var chart = new ApexCharts(document.querySelector("#ip_cluster"),
                options
            );
            chart.render();
        }

        function r_chart() {
            var r_hidden = $('#r_hidden').val();
            if (r_hidden == '' || r_hidden == undefined) {
                r_hidden = 0;
            }
            var options = {
                series: [r_hidden],
                chart: {
                    height: 350,
                    type: 'radialBar',
                    offsetY: -10,
                },

                plotOptions: {
                    radialBar: {
                        startAngle: -135,
                        endAngle: 135,
                        inverseOrder: true,
                        hollow: {
                            margin: 5,
                            size: '60%',
                            image: '{{asset(config('global.asset_path').'/images/dashboard-2/radial-image.png')}}',
                            imageWidth: 140,
                            imageHeight: 140,
                            imageClipped: false,
                        },
                        track: {
                            opacity: 0.4,
                            colors: '#f73164'
                        },
                        dataLabels: {
                            enabled: false,
                            enabledOnSeries: undefined,
                            formatter: function (val, opts) {
                                return val + "%"
                            },
                            textAnchor: 'middle',
                            distributed: false,
                            offsetX: 0,
                            offsetY: 0,

                            style: {
                                fontSize: '14px',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fill: ['#7367F0'],

                            },
                        },
                    }
                },

                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        shadeIntensity: 0.15,
                        inverseColors: false,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100],
                        gradientToColors: ['#f3959e'],
                        type: 'horizontal'
                    },
                },
                stroke: {
                    dashArray: 15,
                    strokecolor: ['#ffffff']
                },

                labels: ['Remaining'],
                colors: ['#f73164'],
            };
            var chart = new ApexCharts(document.querySelector("#r_cluster"),
                options
            );
            chart.render();
        }
    </script>

@endsection
