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
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-wrapper-before"></div>
            <div class="content-header row">
                <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Randomization</h3>

                </div>
                <div class="content-header-right col-md-4 col-12 d-block d-md-none"><a
                        class="btn btn-warning btn-min-width float-md-right box-shadow-4 mr-1 mb-1"
                        href="#"><i class="ft-mail"></i> Dashboard Users</a>
                </div>
            </div>
            <div class="content-body">
                <section id="ordering">
                    <div class="row">
                        <!-- Ajax data source array start-->
                        <div class="col-sm-12">
                            <div class="card">

                                <div class="card-header project-list">
                                    <div class="row">
                                        <div class="col-md-12">   <span class="pull-right"><a class="btn btn-secondary" href="{{route('make_pdf').'/'.request()->id}}"
                                                                          id="add"> <i data-feather="plus-square"> </i>Export PDF</a></span></div>
                                    </div>


                                    <div class="text-2xl">Cluster No: <strong>{{request()->id}}</strong></div>
                                    <div class="text-2xl">District:
                                        <strong>{{isset($data['get_randomized_table'][0]->district) &&$data['get_randomized_table'][0]->district!=''?ucfirst($data['get_randomized_table'][0]->district):'-'}}</strong>
                                    </div>
                                    <div class="text-2xl">Tehsil:
                                        <strong>{{isset($data['get_randomized_table'][0]->tehsil) &&$data['get_randomized_table'][0]->tehsil!=''?ucfirst($data['get_randomized_table'][0]->tehsil):'-'}}</strong>
                                    </div>
                                    <div class="text-2xl">UC:
                                        <strong>{{isset($data['get_randomized_table'][0]->uc) &&$data['get_randomized_table'][0]->uc!=''?ucfirst($data['get_randomized_table'][0]->uc):'-'}}</strong>
                                    </div>
                                    <div class="text-2xl">Village:
                                        <strong>{{isset($data['get_randomized_table'][0]->village) &&$data['get_randomized_table'][0]->village!=''?ucfirst($data['get_randomized_table'][0]->village):'-'}}</strong>
                                    </div>
                                    <div class="text-2xl">Randomization Date:
                                        <strong>{{isset($data['get_randomized_table'][0]->randDT) &&$data['get_randomized_table'][0]->randDT!=''?date('d-M-Y',strtotime($data['get_randomized_table'][0]->randDT)):'-'}}</strong>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="table-responsive2">
                                        <table class=" table display datatables table-striped table-hover"
                                               id="datatable_custom">
                                            <thead>
                                            <tr>
                                                <th width="10%">SNo</th>
                                                <th width="10%">district Name</th>
                                                <th width="10%">Cluster No#</th>
                                                <th width="10%">Village Name</th>
                                                <th width="10%">Household No</th>
                                                <th width="10%">Contact No</th>
                                                <th width="10%">NIC</th>
                                                <th width="10">Head of Household</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $s=0;
                                            @endphp
                                            @if (isset($data['get_randomized_table']) && $data['get_randomized_table'] != '')
                                                @foreach ($data['get_randomized_table'] as $k=>$r)
                                                    @php
                                                        $s++;
                                                    @endphp
                                                    <tr>
                                                        <td width="10%">{{$s}}</td>
                                                        <td width="10%">{{isset($r->dist_id) &&$r->dist_id!=''?ucfirst($r->dist_id):'-'}}</td>
                                                        <td width="10%">{{isset($r->clustercode) &&$r->clustercode!=''?ucfirst($r->clustercode):'-'}}</td>
                                                        <td width="10%">{{isset($r->village) &&$r->village!=''?ucfirst($r->village):'-'}}</td>
                                                        <td width="10%">{{isset($r->hhid) && $r->hhid!=''? $r->hhid:'-'}}</td>
                                                        <td width="10%">{{isset($r->hl14c) && $r->hl14c!=''? $r->hl14c:'-'}}</td>
                                                        <td width="10%">{{isset($r->hl14a) && $r->hl14a!=''? $r->hl14a:'-'}}</td>
                                                        <td width="10%">{{isset($r->head) &&$r->head!=''?ucfirst($r->head):'-'}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th width="10%">SNo</th>
                                                <th width="10%">Household No</th>
                                                <th width="10%">Contact No</th>
                                                <th width="10%">NIC</th>
                                                <th width="10">Head of Household</th>

                                            </tr>
                                            </tfoot>
                                        </table>
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

                <script>
                    $(document).ready(function () {
                        $('#datatable_custom').DataTable({
                            "oSearch": {"sSearch": " "},
                            autoFill: false,
                            attr: {
                                autocomplete: 'off'
                            },
                            initComplete: function () {
                                $(this.api().table().container()).find('input[type="search"]').parent().wrap('<form>').parent().attr('autocomplete', 'off').css('overflow', 'hidden').css('margin', 'auto');
                            },
                            displayLength: 25,
                            lengthMenu: [25, 50, 75, 100],
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    extend: 'copyHtml5', text: 'Copy', className: 'btn btn-sm btn-primary'

                                }, {
                                    extend: 'csvHtml5', text: 'CSV', className: 'btn btn-sm btn-primary'
                                }
                            ]
                        });
                    });
                </script>
@endsection
