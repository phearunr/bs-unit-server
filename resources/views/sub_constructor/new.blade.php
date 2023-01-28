@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <h4>New Sub Constructor</h4>
            <hr>
        </div>  
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('sub_constructors.store') }}" novalidate="novalidate" autocomplete="off" enctype="multipart/form-data" id="CreateSubConstructorInformation">
                        @csrf        
                        <div class="row">
                            <div class="col-12">
                                <h5 class="p-2 mb-0 bg-secondary text-white">Personal Information</h5>
                                <div class="d-flex py-3">
                                    <div style="width: 120px;">
                                        <img src="{{ asset('/img/default_user_avatar.png') }}" width="100%" id="user_avatar" class="rounded-circle d-block">
                                        <div class="my-2 text-center">
                                            <input type="file" id="avatar" name="avatar" class="d-none"> 
                                            <label for="avatar" class="btn btn-primary btn-sm mb-0">Set User Image</label></div>
                                        </div>
                                    <div class="w-100 pl-3">
                                        <div class="form-group">
                                            <label for="name">Full Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter full name" value="{{ old('name') ?? '' }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="join_date">Join Date: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control datepicker" name="join_date" id="join_date" value="{{ old('join_date') ?? Carbon\Carbon::now()->toSystemDateString() }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Workers: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="worker" id="worker" placeholder="Enter number of worker" value="{{ old('worker') ?? '' }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="p-2 mb-2 bg-secondary text-white">Contacts</h5>
                        <div class="row">
                             <div class="col-lg-12 sm-3">
                                <table class="table table-sm table-borderless bg-white" id="table_contact">
                                    <thead>
                                        <tr class="border-bottom">                 
                                            <th width="220px" class="text-left">Contact Type</th>
                                            <th class="text-left">Contact Value</th>
                                            <th width="20px">
                                                <button type="button" class="btn btn-sm btn-primary" name="addContact" id="addContact"><i class="fa fa-plus"></i></button>
                                            </th>
                                    </thead>
                                        </tr>
                                    <tbody id="table_body" class="mainbody">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <h5 class="p-2 mb-2 bg-secondary text-white">Identity Documents</h5>
                        <div class="row">
                            <div class="col-lg-12 sm-3">
                                <table class="table table-borderless table-sm bg-white" id="table_identity_document">
                                    <thead>
                                        <tr class="border-bottom">                 
                                            <th width="180px" class="text-left">{{ ('Type') }}</th>
                                            <th class="text-left">{{ ('Reference') }}</th>
                                            <th width="150px" class="text-left">{{ ('Issue Date') }}</th>
                                            <th width="150px" class="text-left">{{ ('Expiration Date') }}</th>
                                            <th width="170px" class="text-left">{{ ('Image') }}</th>
                                            <th width="20px">
                                                <button type="button" class="btn btn-sm btn-primary" name="addIdentityDocument" id="addIdentityDocument"><i class="fa fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body" class="mainbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <h5 class="p-2 mb-2 bg-secondary text-white">Skills</h5>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" id="checkAll">
                            <label class="form-check-label" for="checkAll">Check All</label>
                        </div>
                        <div class="row px-3">
                            @foreach($sub_constructor_skills as $sub_constructor_skill)
                            <div class="col-md-4 form-check">
                                <input class="form-check-input" type="checkbox" name="sub_constructor_skill[]" value="{{ $sub_constructor_skill->id }}" id="skill-{{$sub_constructor_skill->id}}">
                                <label class="form-check-label" for="skill-{{$sub_constructor_skill->id}}">{{ $sub_constructor_skill->name_km }} - ({{ $sub_constructor_skill->name }})</label>
                            </div>
                            @endforeach 
                        </div>
                        
                        <div class="clearfix"></div><br>

                        <button type="submit" name ="save" id="CreateSubConstructorInformation" class="btn btn-primary btn-sm float-right">{{__("Create New")}}</button> 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script type="text/javascript"> 
   $(document).ready(function() {
        $("#addContact").on('click',function(e){
            e.preventDefault();
            rowCount= $("#table_contact tbody tr").length;
            var html = `<tr>
                            <td>
                                <select class="form-control" name="contact[${rowCount}][type]" id="type">
                                    <option value="MOBILE_PHONE_NUMBER">Moblie Phone Number</option>
                                    <option value="OFFICE_PHONE_NUMBER">Office Phone Number</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="contact[${rowCount}][value]" class="form-control" placeholder="Enter your phone number">
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger btn-remove-table-contact"><i class="fa fa-trash"></i></button>
                            </td>

                        </tr>`;
            $("#table_contact tbody").append(html);      
        });    

        $(document).on('click', '.btn-remove-table-contact', function (e) {        
            $(this).closest('tr').remove();       
        });

        $("#addIdentityDocument").on('click',function(e){
            e.preventDefault();
            rowCount = $("#table_identity_document tbody tr").length;
            var html = `<tr class="text-center">
                            <td>
                                <select class="form-control" name="identity_document[${rowCount}][type]" id="type">
                                    <option value="NATIONAL_ID">National ID</option>
                                    <option value="PASSPORT">Passport</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="identity_document[${rowCount}][reference_no]" class="form-control" placeholder="Enter your reference code">
                            </td>
                            <td>
                                <input type="text" name="identity_document[${rowCount}][issue_date]" class="form-control datepicker">
                            </td>
                            <td>
                                <input type="text" name="identity_document[${rowCount}][expiration_date]" class="form-control datepicker">
                            </td>
                            <td>
                                <input type="file" name="identity_document[${rowCount}][attachment]" id="identity_document_attachment-${rowCount}" class="d-none"/>
                                <label class="btn btn-sm btn-primary" for="identity_document_attachment-${rowCount}">Attachment</label>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger btn-remove-table-identity_document"><i class="fa fa-trash"></i></button>
                            </td>
                           
                        </tr>`;
            $("#table_identity_document tbody").append(html);
            $('.datepicker').datepicker({format: "{{ config('app.js_date_format') }}", orientation : "bottom", autoclose : true});            
        });

        $(document).on('click', '.btn-remove-table-identity_document', function (e) {        
            $(this).closest('tr').remove();       
        });

        $('input[type="file"][name="avatar"]').change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#user_avatar').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);
            }
        })

        $("#remove-avatar-button").click(function (){
            $("#user_avatar").attr('src', "https://ui-avatars.com/api/?name=User avatar&background=00b4ff&color=fff&rounded=true");
            $('input[type="file"][name="avatar"]').val(null);
        }); 

        function getSaleTeamLeaders() {
            const managed_by_element = $('select[name="managed_by"]');
            axios.get('/api/users/roles/sale_team_leader')
            .then( function (response) { 
                clearManagedByItems();
                response.data.data.filter(function (obj) {                 
                    managed_by_element.append(`<option value="${obj.id}">${obj.name}</option>`);
                });
            });
        }

        $('#checkAll').click(function (){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

   });   
</script>
@endpush