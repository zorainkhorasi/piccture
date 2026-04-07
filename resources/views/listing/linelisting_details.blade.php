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
                                <div class="card-header"><h1>LineListing</h1> </div>
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
                                                    <th width="9%">Total Structures</th>
                                                    <th width="9%">Residential Structures</th>
                                                    <th width="9%">Eligible HHs</th>
                                                    <th width="9%">Collecting Tabs</th>
                                                    <th width="9%">Completed Tabs</th>
                                                    <th width="9%">Status</th>
                                                    <th width="9%">Randomized</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                    $s=0;
                                                @endphp
                                                @foreach ($data['linelisting_details'] as $keys=>$value)
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
                                                        <td>{{(isset($value->hl05) && $value->hl05!=''?$value->hl05:'')}}</td>
                                                        <td>{{(isset($value->tehsil) && $value->tehsil!=''?$value->tehsil:'')}}</td>
                                                        <td>{{(isset($value->village) && $value->village!=''?$value->village:'')}}</td>
                                                        <td>{{(isset($value->village_code) && $value->village_code!=''?$value->village_code:'')}}</td>
                                                        <td>{{(isset($value->cluster_no) && $value->cluster_no!=''?$value->cluster_no:'')}}</td>
                                                        <td>{{isset($value->structures) && $value->structures!=''?$value->structures:'0'}}</td>
                                                        <td>{{isset($value->residential_structures) && $value->residential_structures!=''?$value->residential_structures:'0'}}</td>
                                                        <td>{{isset($value->eligible_households) && $value->eligible_households!=''?$value->eligible_households:'0'}}</td>
                                                        <td >{{isset($value->collecting_tabs) && $value->collecting_tabs!=''?$value->collecting_tabs:'0'}}</td>
                                                        <td >{{isset($value->completed_tabs) && $value->completed_tabs!=''?$value->completed_tabs:'0'}}</td>

                                                        <td>
                                                            @php
                                                                $rand_show = '';
                                                                                if ($value->structures == 0 || $value->structures == '') {
                                                                                    $rand_show = '2';
                                                                                    $stat = 'Remaining';
                                                                                } else if ($value->collecting_tabs !=$value->completed_tabs) {
                                                                                    $rand_show = '2';
                                                                                    $stat = 'In Progress';
                                                                                }else if ($value->collecting_tabs>2) {
                                                                                    $rand_show = '4';
                                                                                    $stat = 'The devices should not be greater than 2';
                                                                                } else if (isset($value->eligible_households) && $value->eligible_households<=19 && $value->collecting_tabs ==$value->completed_tabs) {
                                                                                    $rand_show = '2';
                                                                                    $stat = 'Completed but not enough eligible HHs';
                                                                                } else if ($value->randomized != '1' && isset($value->eligible_households) && $value->eligible_households>=20 && $value->collecting_tabs ==$value->completed_tabs) {
                                                                                    $rand_show = '1';
                                                                                    $stat = 'Ready to Randomize';
                                                                                }else if ($value->randomized == '1') {
                                                                                    $rand_show = '3';
                                                                                    $stat = 'Randomized';
                                                                                } else {
                                                                                    $rand_show = '2';
                                                                                    $stat = '-';
                                                                                }
                                                            @endphp
                                                            {{$stat}}
                                                        </td>
                                                        <td>
                                                            @php
                                                                if (isset($data['permission'][0]->CanAdd) && $data['permission'][0]->CanAdd == 1 && $rand_show == '1') {
                                                                           echo '<a href="javascript:void(0)" onclick="randomizeBtn(this)" data-cluster="' . $cluster_no . '"
                                                                           class="btn btn-sm btn-primary text-center rand_btn">Randomize</a>';
                                                                       } elseif ($rand_show == '3' ) {
                                                                           echo '<a href="'.route('rs_randomized_detail').'/'.$cluster_no.'" target="_blank" class="btn btn-sm btn-success text-center">View</a> ';
                                                                           echo '| <a href="'.route('make_pdf').'/'.$cluster_no.'" target="_blank" class="btn btn-sm btn-danger text-center">Download Pdf</a> ';
                                                                       } elseif ($rand_show == '4' ) {
                                                                           echo '<a href="javascript:void(0)"  class="btn btn-sm btn-danger text-center">Error</a> ';
                                                                                    if(Auth::user()->idGroup==1){
                                                                                        echo '<a href="javascript:void(0)" onclick="randomizeBtn(this)" data-cluster="' . $cluster_no . '"
                                                                           class="btn btn-sm btn-primary text-center rand_btn">Randomize</a>';
                                                                                    }
                                                                       } else {
                                                                            echo '-';
                                                                       }

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
                                                    <th width="9%">Total Structures</th>
                                                    <th width="9%">Residential Structures</th>
                                                    <th width="9%">Eligible HHs</th>
                                                    <th width="9%">Collecting Tabs</th>
                                                    <th width="9%">Completed Tabs</th>
                                                    <th width="9%">Status</th>
                                                    <th width="9%">Randomized</th>
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
