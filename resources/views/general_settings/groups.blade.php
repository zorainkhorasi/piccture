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
            <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block">Group</h3>
                <div class="breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Settings</a>
                            </li>
                            <li class="breadcrumb-item active">Groups
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
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
                            <div class="card-header">
                                <h4 class="card-title">Groups
                                    <button type="button" class="btn bg-gradient-x-blue-cyan white addbtn">
                                        <i class="ft-plus"></i> Add New
                                    </button>
                                </h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="dt_colVis_buttons"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                            <table class="table table-striped table-bordered show-child-rows" id="datatable_custom">
                                <thead>
                                <tr>
                                    <th>SNo</th>
                                    <th>Group</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sno = 1
                                @endphp
                                @foreach ($data['data'] as $keys=>$value)
                                    <tr data-id="{{ $value->idGroup }}">
                                        <td>{{$sno++}}</td>
                                        <td>{{(isset($value->groupName) && $value->groupName!=''?$value->groupName:'')}}</td>
                                        <td>
                                            <a href="{{route('groupSettings', $value->idGroup )}}"
                                               data-original-title="Edit"
                                               title="Group Settings">
                                                <i data-feather="settings" class="txt-info"></i>
                                            </a>

                                            <a href="javascript:void(0)" data-original-title="Edit"
                                               title="Edit"
                                               onclick="getEdit(this)">
                                                <i data-feather="edit" class="txt-secondary"></i>
                                            </a>
                                            <a href="javascript:void(0)" data-original-title="Delete"
                                               title="Delete"
                                               onclick="getDelete(this)">
                                                <i data-feather="trash-2" class="txt-danger"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>SNo</th>
                                    <th>Group</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Add Modal-->
                        <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel_add"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content ">
                                   
                                    <div class="modal-header bg-primary white">
                                        <h4 class="modal-title white" id="myModalLabel_add">Add Group</h4>
                                        <button class="btn-close white" type="button" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body  ">
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="groupName">Group: </label>
                                            <input type="text" class="form-control groupName" id="groupName">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn grey btn-secondary" data-bs-dismiss="modal"
                                                aria-label="Close" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" class="btn btn-primary mybtn" onclick="addData()">Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal-->
                        <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel_edit"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content ">
                                    <div class="loader-box hide loader">
                                        <div class="loader-1 myloader"></div>
                                        <div class="myloader"> Loading..</div>
                                    </div>
                                    <div class="modal-header bg-primary white">
                                        <h4 class="modal-title white" id="myModalLabel_edit">Edit Group</h4>
                                        <input type="hidden" id="hiddenEditId" name="hiddenEditId" value="">
                                        <button class="btn-close white" type="button" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body  ">
                                        <div class="mb-1 form-group">
                                            <label class="col-form-label" for="edit_groupName">Group: </label>
                                            <input type="text" class="form-control edit_groupName" id="edit_groupName"
                                                   required>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn grey btn-secondary" data-bs-dismiss="modal"
                                                aria-label="Close" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" class="btn btn-primary mybtn" onclick="editData()">Edit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal-->
                        <div class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel_delete"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content ">
                                    <div class="loader-box hide loader">
                                        <div class="loader-1 myloader"></div>
                                        <div class="myloader"> Loading..</div>
                                    </div>
                                    <div class="modal-header bg-primary white">
                                        <h4 class="modal-title white" id="myModalLabel_delete">Delete Group</h4>
                                        <input type="hidden" id="hiddenDeleteId" name="hiddenDeleteId" value="">
                                        <button class="btn-close white" type="button" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body  ">
                                        <div class="px-3">
                                            <p>Are you sure, you want to delete it?</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn grey btn-secondary" data-bs-dismiss="modal"
                                                aria-label="Close" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" class="btn btn-primary mybtn" onclick="deleteData()">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Ajax data source array end-->
        </div>
    </div>

@endsection

@section('script')

<script src="{{asset(config('global.asset_path_bnp').'/assets/vendors/js/tables/datatable/datatables.min.js')}}"
        type="text/javascript"></script>
        <script src="{{asset(config('global.asset_path').'/js/select2/select2.full.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('.myselect2').select2({
                dropdownParent: $('#addModal')
            });
            $('.addbtn').click(function () {
                $('#addModal').modal('show');
            });
            $('#datatable_custom').DataTable({
                "displayLength": 50,
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

        function addData() {
            $('#groupName').css('border', '1px solid #babfc7');
            var data = {};
            data['groupName'] = $('#groupName').val();
            if (data['groupName'] == '' || data['groupName'] == undefined) {
                $('#groupName').css('border', '1px solid red');
                toastMsg('Group', 'Invalid Group Name', 'danger');
            } else {
                showloader();
                CallAjax('{{ route('addGroup') }}', data, 'POST', function (result) {
                    hideloader();
                    if (result !== '' && JSON.parse(result).length > 0) {
                        var response = JSON.parse(result);
                        try {
                            toastMsg(response[0], response[1], response[2]);
                            if (response[0] === 'Success') {
                                hideModal('addModal');
                                setTimeout(function () {
                                    window.location.reload();
                                }, 700);
                            }
                        } catch (e) {
                        }
                    } else {
                        toastMsg('Error', 'Something went wrong while uploading data', 'danger');
                    }
                });
            }
        }

        function getEdit(obj) {
            var data = {};
            data['id'] = $(obj).parents('tr').attr('data-id');
            if (data['id'] != '' && data['id'] != undefined) {
                CallAjax('{{ route('detailGroup') }}', data, 'GET', function (result) {
                    if (result != '' && JSON.parse(result).length > 0) {
                        var a = JSON.parse(result);
                        try {
                            $('#hiddenEditId').val(data['id']);
                            $('#edit_groupName').val(a[0]['groupName']);
                        } catch (e) {
                        }
                        showModal('editModal');
                    }
                });
            }
        }

        function editData() {
            $('#edit_groupName').css('border', '1px solid #babfc7');
            var flag = 0;
            var data = {};
            data['id'] = $('#hiddenEditId').val();
            data['groupName'] = $('#edit_groupName').val();
            if (data['id'] == '' || data['id'] == undefined || data['id'].length < 1) {
                flag = 1;
                toastMsg('Error', 'Invalid Group Id', 'danger');
                return false;
            }
            if (data['groupName'] == '' || data['groupName'] == undefined || data['groupName'].length < 1) {
                $('#edit_groupName').css('border', '1px solid red');
                toastMsg('Group', 'Invalid Group Name', 'danger');
                flag = 1;
                return false;
            }
            if (flag === 0) {
                showloader();
                CallAjax('{{ route('editGroup') }}', data, 'POST', function (result) {
                    hideloader();
                    if (result !== '' && JSON.parse(result).length > 0) {
                        var response = JSON.parse(result);
                        try {
                            toastMsg(response[0], response[1], response[2]);
                            if (response[0] === 'Success') {
                                hideModal('editModal');
                                setTimeout(function () {
                                    window.location.reload();
                                }, 700);
                            }
                        } catch (e) {
                        }
                    } else {
                        toastMsg('Error', 'Something went wrong while uploading data', 'danger');
                    }
                });
            } else {
                toastMsg('Group', 'Something went wrong', 'danger');
            }
        }

        function getDelete(obj) {
            $('#hiddenDeleteId').val($(obj).parents('tr').attr('data-id'));
            showModal('deleteModal');
        }

        function deleteData() {
            var data = {};
            data['id'] = $('#hiddenDeleteId').val();
            if (data['id'] == '' || data['id'] == undefined) {
                $('#hiddenEditId').css('border', '1px solid red');
                toastMsg('Error', 'Invalid Group Id', 'danger');
                return false;
            } else {
                showloader();
                CallAjax('{{ route('deleteGroup') }}', data, 'POST', function (result) {
                    hideloader();
                    if (result !== '' && JSON.parse(result).length > 0) {
                        var response = JSON.parse(result);
                        try {
                            toastMsg(response[0], response[1], response[2]);
                            if (response[0] === 'Success') {
                                hideModal('deleteModal');
                                setTimeout(function () {
                                    window.location.reload();
                                }, 700);
                            }
                        } catch (e) {
                        }
                    } else {
                        toastMsg('Error', 'Something went wrong while uploading data', 'danger');
                    }
                });
            }
        }
    </script>
@endsection
