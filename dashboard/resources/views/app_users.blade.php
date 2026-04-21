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
                <h3 class="content-header-title mb-0 d-inline-block">App Users</h3>
                <div class="breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">

                            <li class="breadcrumb-item active">App Users
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-4 col-12 d-block d-md-none">
                    <a
                        class="btn btn-warning btn-min-width float-md-right box-shadow-4 mr-1 mb-1"
                        href="#"><i class="ft-mail"></i> App Users
                    </a>

            </div>
        </div>
        <div class="content-body">
            <section id="ordering">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">App Users

                                </h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                     @if(isset($data['permission'][0]->CanAdd) && $data['permission'][0]->CanAdd == 1)
                                        <span><a class="btn btn-primary addbtn" href="javascript:void(0)"
                                                 data-uk-modal="{target:'#addModal'}" id="add"> <i data-feather="plus-square"> </i>Create New User</a></span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                            <table class="table table-striped table-bordered show-child-rows" id="datatable_custom">

                                <thead>
                                <tr>
                                    <th>SNo</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Designation</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sno = 1
                                @endphp
                                @foreach ($data['data'] as $keys=>$value)
                                    <tr data-id="{{ $value->id }}">
                                        <td>{{$sno++}}</td>
                                        <td>{{(isset($value->full_name) && $value->full_name!=''?$value->full_name:'')}}</td>
                                        <td>{{(isset($value->username) && $value->username!=''?$value->username:'')}}</td>
                                      <!--   <td>{{(isset($value->ucname) && $value->ucname!=''?$value->ucname:'')}}</td> -->
                                        <td>{{(isset($value->designation) && $value->designation!=''?$value->designation:'')}}</td>
                                     <!--    <td>{{(isset($value->vtype) && $value->vtype!=''?$value->vtype:'')}}</td> -->
                                        <td data-id="{{ $value->id }}"
                                            data-fullname="{{ $value->full_name }}"
                                            data-username="{{ $value->username }}">
                                            @if(isset($data['permission'][0]->CanEdit) && $data['permission'][0]->CanEdit == 1)
                                                <a href="javascript:void(0)" title="Reset Password"
                                                   onclick="getResetPwd(this)">
                                                    <i data-feather="settings" class="txt-primary"></i>
                                                </a>
                                                <a href="javascript:void(0)" data-original-title="Edit"
                                                   title="Edit"
                                                   onclick="getEdit(this)">
                                                    <i data-feather="edit" class="txt-secondary"></i>
                                                </a>
                                            @endif
                                            @if(isset($data['permission'][0]->CanDelete) && $data['permission'][0]->CanDelete == 1)
                                                <a href="javascript:void(0)" data-original-title="Delete"
                                                   title="Delete"
                                                   onclick="getDelete(this)">
                                                    <i data-feather="trash-2" class="txt-danger"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>SNo</th>
                                    <th>Name</th>
                                    <th>Username</th>

                                    <th>Designation</th>
                                   <!--  <th>Staff Category</th> -->
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Add Modal-->
                        @if(isset($data['permission'][0]->CanAdd) && $data['permission'][0]->CanAdd == 1)
                            <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel_add"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content ">
                                        <div class="loader-box hide loader">
                                            <div class="loader-1 myloader"></div>
                                            <div class="myloader"> Loading..</div>
                                        </div>
                                        <div class="modal-header bg-primary white">
                                            <h4 class="modal-title white" id="myModalLabel_add">Add User</h4>
                                            <button class="btn-close white" type="button" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body  ">
                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="fullName">Full Name: </label>
                                                <input type="text" class="form-control fullName"
                                                       id="fullName" required>
                                            </div>
                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="userName">User Name: </label>
                                                <input type="email" class="form-control userName" minlength="8"
                                                       id="userName" required>
                                            </div>
                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="userPassword">Password</label>
                                                <input class="form-control" id="userPassword" type="text"
                                                       name="userPassword"
                                                       required="" minlength="8"
                                                       placeholder="*********" autocomplete="current-userPassword">
                                            </div>
                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="district">District: </label>
                                                <select class="form-control col-sm-12" id="district">
                                                    <option value="0">Select District</option>
                                                    @if (isset($data['districts']) && $data['districts'] != '')
                                                        @foreach ($data['districts'] as $keys=>$d)
                                                            <option
                                                                value="{{(isset($d->district_code) && $d->district_code!=''?$d->district_code:$d->district_name)}}">
                                                                {{(isset($d->district_name) && $d->district_name!=''?$d->district_name:$d->district_code)}}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                          <!--   <div class="mb-1 form-group">
                                                <label class="col-form-label" for="uc">UC: </label>
                                                <select class="form-control col-sm-12" id="uc" required>
                                                    <option value="0" data-uc="0">Select UC</option>
                                                </select>
                                            </div> -->
                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="designation">Designation: </label>
                                                <input type="text" class="form-control" id="designation" required>
                                            </div>
                                           <!--  <div class="mb-1 form-group">
                                                <label class="col-form-label" for="vtype">Staff Category: </label>
                                                <select class="form-control col-sm-12" id="vtype" name="vtype" required>
                                                    <option value="0">Select Staff Category</option>
                                                    <option value="ORT">Out Reach</option>
                                                    <option value="STC">Static</option>
                                                </select>
                                            </div> -->
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
                        @endif
                        <!-- Edit Modal-->
                        @if(isset($data['permission'][0]->CanEdit) && $data['permission'][0]->CanEdit == 1)
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
                                            <h4 class="modal-title white" id="myModalLabel_edit">Edit User</h4>
                                            <input type="hidden" id="hiddenEditId" name="hiddenEditId" value="">
                                            <button class="btn-close white" type="button" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body  ">
                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="fullName_edit">Full Name: </label>
                                                <input type="text" class="form-control fullName_edit"
                                                       id="fullName_edit" required>
                                            </div>
                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="userName_edit">User Name: </label>
                                                <input type="email" class="form-control userName_edit" minlength="8"
                                                       id="userName_edit" readonly disabled required>
                                            </div>
                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="district_edit">District: </label>
                                                <select class="form-control col-sm-12" id="district_edit" required>
                                                    <option value="0">Select District</option>
                                                    @if (isset($data['districts']) && $data['districts'] != '')
                                                        @foreach ($data['districts'] as $keys=>$d)
                                                            <option
                                                                value="{{(isset($d->district_code) && $d->district_code!=''?$d->district_code:$d->district_name)}}">
                                                                {{(isset($d->district_name) && $d->district_name!=''?$d->district_name:$d->district_code)}}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <!-- <div class="mb-1 form-group">
                                                <label class="col-form-label" for="uc_edit">UC: </label>
                                                <select class="form-control col-sm-12" id="uc_edit" required>
                                                    <option value="0" data-uc="0">Select UC</option>
                                                </select>
                                            </div> -->
                                            <div class="mb-1 form-group">
                                                <label class="col-form-label"
                                                       for="designation_edit">Designation: </label>
                                                <input type="text" class="form-control" id="designation_edit" required>
                                            </div>

                                            <!-- <div class="mb-1 form-group">
                                                <label class="col-form-label" for="vtype_edit">Staff Category: </label>
                                                <select class="form-control col-sm-12" id="vtype_edit" name="vtype_edit" required>
                                                    <option value="0">Select Staff Category</option>
                                                    <option value="ORT">Out Reach</option>
                                                    <option value="STC">Static</option>
                                                </select>
                                            </div> -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn grey btn-secondary" data-bs-dismiss="modal"
                                                    aria-label="Close" data-dismiss="modal">Close
                                            </button>
                                            <button type="button" class="btn btn-primary mybtn" onclick="editData()">
                                                Edit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade text-left" id="editPwdModal" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel_editPwd"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary white">
                                            <h4 class="modal-title white" id="myModalLabel_editPwd">Reset Password</h4>
                                            <input type="hidden" id="editPwd_idUser" name="editPwd_idUser">
                                        </div>
                                        <div class="modal-body">

                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="edit_fullNamePwd">Full Name: </label>
                                                <input type="text" class="form-control edit_fullNamePwd"
                                                       id="edit_fullNamePwd" readonly disabled required>
                                            </div>
                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="edit_userNamePwd">User Name: </label>
                                                <input type="email" class="form-control edit_userNamePwd" minlength="8"
                                                       id="edit_userNamePwd" readonly disabled required>
                                            </div>
                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="edit_userPassword">Password</label>
                                                <input class="form-control myPwdInput" id="edit_userPassword"
                                                       type="text"
                                                       name="edit_userPassword"
                                                       required="" minlength="8"
                                                       placeholder="*********" autocomplete="current-edit_userPassword">
                                            </div>
                                            <div class="mb-1 form-group">
                                                <label class="col-form-label" for="edit_userPasswordConfirm">Confirm
                                                    Password</label>
                                                <input class="form-control myPwdInput" id="edit_userPasswordConfirm"
                                                       type="text"
                                                       name="edit_userPasswordConfirm"
                                                       required="" minlength="8"
                                                       placeholder="*********"
                                                       autocomplete="current-edit_userPasswordConfirm">
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn grey btn-secondary" data-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="button" class="btn btn-danger" onclick="resetPwd()">Reset
                                                Password
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(isset($data['permission'][0]->CanDelete) && $data['permission'][0]->CanDelete == 1)
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
                                            <h4 class="modal-title white" id="myModalLabel_delete">Delete User</h4>
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
                        @endif
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
            $('#fullName').css('border', '1px solid #babfc7');
            $('#userName').css('border', '1px solid #babfc7');
            $('#userPassword').css('border', '1px solid #babfc7');
            var flag = 0;
            var data = {};
            data['fullName'] = $('#fullName').val();
            data['userName'] = $('#userName').val();
            data['userPassword'] = $('#userPassword').val();
            data['district'] = $('#district').val();
           /* data['uc'] = $('#uc').val();*/
            data['designation'] = $('#designation').val();
           /* data['vtype'] = $('#vtype').val();*/
            if (data['fullName'] == '' || data['fullName'] == undefined) {
                $('#fullName').css('border', '1px solid red');
                flag = 1;
                toastMsg('Full Name', 'Invalid Full Name', 'danger');
                return false;
            }
            if (!data['userName'] || data['userName'].length !== 8) {
                $('#userName').css('border', '1px solid red');
                flag = 1;
                toastMsg('User Name', 'Username must be exactly 8 characters long', 'danger');
                return false;
            }
            /*if (data['userPassword'].length < 8) {
                $('#userPassword').css('border', '1px solid red');
                flag = 1;
                toastMsg('Password', 'Password must be 8 characters long', 'danger');
                return false;
            }*/

            if (data['userName'] == '' || data['userName'] == undefined || data['userName'].length < 8) {
                $('#userName').css('border', '1px solid red');
                flag = 1;
                toastMsg('User Name', 'Invalid User Name', 'danger');
                return false;
            }

            if (data['userPassword'] == '' || data['userPassword'] == undefined || data['userPassword'].length < 8) {
                $('#userPassword').css('border', '1px solid red');
                flag = 1;
                toastMsg('Password', 'Invalid Password', 'danger');
                return false;
            }
            if (data['district'] == '' || data['district'] == undefined || data['district'] == 0) {
                $('#district').css('border', '1px solid red');
                flag = 1;
                toastMsg('District', 'Invalid District', 'danger');
                return false;
            }
            /*if (data['uc'] == '' || data['uc'] == undefined || data['uc'] == 0) {
                $('#uc').css('border', '1px solid red');
                flag = 1;
                toastMsg('UC', 'Invalid UC', 'danger');
                return false;
            }
            if (data['vtype'] == '' || data['vtype'] == undefined || data['vtype']==0) {
                $('#vtype').css('border', '1px solid red');
                flag = 1;
                toastMsg('Staff Category', 'Invalid Staff Category', 'danger');
                return false;
            }*/


            if (flag == 0) {
                showloader();
                CallAjax('{{ url('/App_Users/addAppUsers') }}', data, 'POST', function (result) {
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
            } else {
                toastMsg('User', 'Something went wrong', 'danger');
            }
        }

        function getEdit(obj) {
            var data = {};
            data['id'] = $(obj).parents('tr').attr('data-id');
            if (data['id'] != '' && data['id'] != undefined) {
                CallAjax('{{ url('/App_Users/detail/') }}', data, 'GET', function (result) {
                    if (result != '' && JSON.parse(result).length > 0) {
                        var a = JSON.parse(result);
                        try {
                            $('#hiddenEditId').val(data['id']);
                            $('#fullName_edit').val(a[0]['full_name']);
                            $('#userName_edit').val(a[0]['username']);
                            $('#district_edit').val(a[0]['dist_id']);

                            $('#designation_edit').val(a[0]['designation']);

                        } catch (e) {
                        }
                        showModal('editModal');
                    }
                });
            }
        }

        function editData() {
            $('#fullName_edit').css('border', '1px solid #babfc7');
            var flag = 0;
            var data = {};
            data['id'] = $('#hiddenEditId').val();
            data['fullName'] = $('#fullName_edit').val();
            data['district'] = $('#district_edit').val();
            data['designation'] = $('#designation_edit').val();
            if (data['id'] == '' || data['id'] == undefined) {
                $('#hiddenEditId').css('border', '1px solid red');
                flag = 1;
                toastMsg('Error', 'Invalid User Id', 'danger');
                return false;
            }
            if (data['fullName'] == '' || data['fullName'] == undefined) {
                $('#fullName_edit').css('border', '1px solid red');
                flag = 1;
                toastMsg('Full Name', 'Invalid Full Name', 'danger');
                return false;
            }

            if (data['district'] == '' || data['district'] == undefined || data['district'] == 0) {
                $('#district').css('border', '1px solid red');
                flag = 1;
                toastMsg('District', 'Invalid District', 'danger');
                return false;
            }

            if (flag === 0) {
                showloader();
                CallAjax('{{ url('/App_Users/editAppUsers') }}', data, 'POST', function (result) {
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
                toastMsg('User', 'Something went wrong', 'danger');
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
                toastMsg('Error', 'Invalid User Id', 'danger');
                return false;
            } else {
                showloader();
                CallAjax('{{ url('/App_Users/deleteAppUsers') }}', data, 'POST', function (result) {
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

        function getResetPwd(obj) {
            var data = {};
            data['id'] = $(obj).parent('td').attr('data-id');
            data['fullname'] = $(obj).parent('td').attr('data-fullname');
            data['username'] = $(obj).parent('td').attr('data-username');
            if (data['id'] != '' && data['id'] != undefined) {
                $('#editPwd_idUser').val(data['id']);
                $('#edit_fullNamePwd').val(data['fullname']);
                $('#edit_userNamePwd').val(data['username']);
                $('#editPwdModal').modal('show');
            } else {
                toastMsg('User', 'Invalid User', 'danger');
            }
        }

        function resetPwd() {
            $('#edit_userNamePwd').css('border', '1px solid #babfc7');
            $('#edit_fullNamePwd').css('border', '1px solid #babfc7');
            $('#edit_userPassword').css('border', '1px solid #babfc7');
            $('#edit_userPasswordConfirm').css('border', '1px solid #babfc7');
            var flag = 0;
            var data = {};
            data['id'] = $('#editPwd_idUser').val();
            data['fullName'] = $('#edit_fullNamePwd').val();
            data['userName'] = $('#edit_userNamePwd').val();
            data['userPassword'] = $('#edit_userPassword').val();
            data['userPasswordConfirm'] = $('#edit_userPasswordConfirm').val();

            if (data['id'] == '' || data['id'] == undefined || data['id'].length < 1) {
                flag = 1;
                ('#edit_userNamePwd').css('border', '1px solid red');
                toastMsg('User', 'Invalid User', 'danger');
                return false;
            }
            if (data['fullName'] == '' || data['fullName'] == undefined) {
                $('#edit_fullName').css('border', '1px solid red');
                flag = 1;
                toastMsg('Full Name', 'Invalid Full Name', 'danger');
                return false;
            }
            if (data['userPassword'].length < 8) {
                $('#userPassword').css('border', '1px solid red');
                flag = 1;
                toastMsg('Password', 'Password must be 8 characters long', 'danger');
                return false;
            }

            if (data['userPassword'] == '' || data['userPassword'] == undefined) {
                $('#edit_userPassword').css('border', '1px solid red');
                flag = 1;
                toastMsg('Password', 'Invalid Password', 'danger');
                return false;
            }
            if (data['userPasswordConfirm'] == '' || data['userPasswordConfirm'] == undefined || data['userPasswordConfirm'] != data['userPassword']) {
                $('#edit_userPasswordConfirm').css('border', '1px solid red');
                flag = 1;
                toastMsg('Confrim Password', 'Invalid Confrim Password', 'danger');
                return false;
            }
            if (flag === 0) {
                showloader();
                CallAjax('{{ url('/App_Users/resetPwd') }}', data, 'POST', function (result) {
                    hideloader();
                    if (result !== '' && JSON.parse(result).length > 0) {
                        var response = JSON.parse(result);
                        try {
                            toastMsg(response[0], response[1], response[2]);
                            if (response[0] === 'Success') {
                                hideModal('editPwdModal');
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
