@extends('layouts.simple.master')
@section('title',  trans('lang.pages_main_heading')  )

@section('css')

@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.pages_main_heading') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ trans('lang.pages_main_heading') }}</li>
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-wrapper-before"></div>
            <div class="content-header row">

                <div class="content-header-right col-md-4 col-12 d-block d-md-none"><a
                        class="btn btn-warning btn-min-width float-md-right box-shadow-4 mr-1 mb-1"
                        href="#"><i class="ft-mail"></i> Groups</a>
                </div>
            </div>
            <div class="content-body">
                <section id="ordering">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header"><h1>Data Collection</h1> </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered show-child-rows"
                                                   id="datatable_custom">
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th width="9%">SNo</th>
                                                    <th width="9%">District </th>
                                                    <th width="9%">Tehsil</th>
                                                    <th width="9%">Village Name</th>
                                                    <th width="9%">Village Code</th>
                                                    <th width="9">Cluster No</th>
                                                    <th width="9%">HH Randomized</th>
                                                    <th width="9%">HH Visited</th>
                                                    <th width="9%">Status</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                    $s=0;
                                                @endphp
                                                @foreach ($data['details'] as $keys=>$value)
                                                    @php
                                                        $s++;
                                                            if(isset($value->cluster_no) && $value->cluster_no!=''){
                                                                $cluster_no=$value->cluster_no;
                                                            }else{
                                                                $cluster_no=0;
                                                            }
                                                    @endphp
                                                    <tr>
                                                        <td width="9%">{{$s}}</td>
                                                        <td>{{(isset($value->district) && $value->district!=''?$value->district:'')}}</td>
                                                        <td>{{(isset($value->tehsil) && $value->tehsil!=''?$value->tehsil:'')}}</td>
                                                        <td>{{(isset($value->village) && $value->village!=''?$value->village:'')}}</td>
                                                        <td>{{(isset($value->village_code) && $value->village_code!=''?$value->village_code:'')}}</td>
                                                        <td>{{(isset($value->cluster_no) && $value->cluster_no!=''?$value->cluster_no:'')}}</td>
                                                        <td>{{isset($value->hh_randomized) && $value->hh_randomized!=''?$value->hh_randomized:'0'}}</td>
                                                        <td>{{isset($value->hh_collected) && $value->hh_collected!=''?$value->hh_collected:'0'}}</td>

                                                        <td width="9%">
                                                            @php
                                                                $status = '';
                                                                if ($value->hh_randomized > 0) {
                                                                      if ($value->hh_collected >=$value->hh_randomized ) {
                                                                        $status = '<a href="javascript:void(0)" class="btn btn-sm btn-success text-center">Completed</a> ';
                                                                    } else if($value->hh_collected!=0) {
                                                                         $status = '<a href="javascript:void(0)" class="btn btn-sm btn-primary text-center">In Progress</a> ';
                                                                    }else if($value->hh_collected==0) {
                                                                         $status = '<a href="javascript:void(0)" class="btn btn-sm btn-warning text-center">Remaining</a> ';
                                                                    }
                                                                } else {
                                                                   $status = '<a href="javascript:void(0)" class="btn btn-sm btn-danger text-center">Not Randomized</a> ';
                                                                }
                                                                echo $status;
                                                            @endphp
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                                <tfoot class="thead-dark">
                                                <tr>
                                                    <th width="9%">SNo</th>
                                                    <th width="9%">District </th>
                                                    <th width="9%">Tehsil</th>
                                                    <th width="9%">Village Name</th>
                                                    <th width="9%">Village Code</th>
                                                    <th width="9">Cluster No</th>
                                                    <th width="9%">HH Randomized</th>
                                                    <th width="9%">HH Visited</th>
                                                    <th width="9%">Status</th>

                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>


                                        <!-- Delete Modal-->


                                    </div>
                                </div>
                            </div>
                            <!-- Ajax data source array end-->
                        </div>
                    </div>

                    @endsection

                    @section('script')

                        <script
                            src="{{asset(config('global.asset_path_bnp').'/assets/vendors/js/tables/datatable/datatables.min.js')}}"
                            type="text/javascript"></script>


                        <script>
                            $(document).ready(function () {
                                $('#datatable_custom').DataTable({
                                    "displayLength": 100,
                                    "dom": 'Bfrtip',
                                    "oSearch": {"sSearch": " "},
                                    autoFill: false,
                                    attr: {
                                        autocomplete: 'off'
                                    },
                                    initComplete: function () {
                                        $(this.api().table().container()).find('input[type="search"]').parent().wrap('<form>').parent().attr('autocomplete', 'off').css('overflow', 'hidden').css('margin', 'auto');
                                    },
                                });
                            });
                            function randomizeBtn(obj) {

                                $('.rand_btn').css('display', 'none').attr('disabled', 'disabled');
                                var data = {};
                                data['cluster_no'] = $(obj).attr('data-cluster');
                               // alert( data['cluster_no']);return


                                if (data['cluster_no'] == '' || data['cluster_no'] == undefined || data['cluster_no'] == '0') {
                                    toastMsg('Cluster', 'Invalid Cluster No', 'danger');

                                    $('.rand_btn').css('display', 'block').removeAttr('disabled', 'disabled');
                                    return false;
                                } else {
                                    showloader();
                                    CallAjax('{{ route('rs_systematic_randomizer') }}', data, 'POST', function (result) {
                                        $('.rand_btn').css('display', 'block').removeAttr('disabled', 'disabled');
                                        hideloader();
                                        if (result !== '' && JSON.parse(result).length > 0) {
                                            var response = JSON.parse(result);
                                            try {
                                                toastMsg(response[0], response[1], response[2]);
                                                if (response[0] === 'Success') {
                                                    setTimeout(function () {
                                                        window.location.reload();
                                                    }, 700);
                                                }
                                            } catch (e) {
                                            }
                                        } else {

                                            toastMsg('Error', 'Something went wrong', 'danger');
                                        }
                                    });

                                }
                            }
                        </script>
@endsection
