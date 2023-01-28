@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">         
    <div class="row justify-content-center">
        <div class="col-md-5">
            <blockquote class="blockquote text-left">
                <p class="mb-0">User Information.</p>
                <footer class="blockquote-footer">
                    A good user profile will help you to identify problem quickly. Please provide an accurate and full infomration of user.
                </footer>
            </blockquote>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">                    
                    @if ($errors->hasBag('user_profile_information'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->user_profile_information->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('user_profile_information_status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('user_profile_information_status') }}
                        </div>
                    @endif 
                    <form method="POST" action="{{ route('admin.user.personal_information.update', [ 'id' => $user->id ]) }}" enctype="multipart/form-data" novalidate="novalidate" autocomplete="false" id="UpdatePersonalInformationForm">    
                        @csrf
                        @method('PUT')
                        <img src="{{ $user->avatar_url }}" alt="user avatar" id="user_avatar" class="rounded-circle d-block" width="80px">
                        <span class="text-muted font-italic">
                            <small>Profile image should be sqaure and not greater than 512px x 512px</small>
                        </span>
                        <div class="my-2">
                            <input type="file" class="d-none" id="avatar" name="avatar">
                            <label class="btn btn-primary btn-sm mb-0" for="avatar">Set User Image</label>                           
                        </div>
                        <div class="form-group">
                            <label for="name">Full Name:</label>
                            <input type="text" class="form-control form-control-sm" name="name" id="name" value="{{ old('name') ?? $user->name }}" />
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select class="form-control form-control-sm" name="gender" id="gender">                          
                                <option value="Male" {{ old("gender") == 'Male' || $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old("gender") == 'Female' || $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="birthdate">Date of Birth: <span class="text-muted">(format: {{ config('app.js_date_format') }})</span></label>
                            <input type="text" class="form-control form-control-sm datepicker" name="birthdate" 
                                value="{{ old('birthdate') ?? $user->birthdate ? $user->birthdate->toSystemDateString() : '' }}">                           
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number: </label>
                            <input type="text" class="form-control form-control-sm" name="phone_number" id="phone_number" value="{{ old('phone_number') ?? $user->phone_number }}" />                                      
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address: </label>
                            <input type="email" class="form-control form-control-sm"  name="email" id="email" value="{{ old('email', $user->email) }}" />
                        </div>
                        <div class="form-group">
                            <label for="department_id">Department: </label>
                            <select class="form-control form-control-sm" name="department_id" id="department_id" >
                                <option value="">None</option>
                                @foreach(\App\Department::all() as $department)
                                <option value="{{ $department->id }}" {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="position">Position: </label>
                            <input type="text" class="form-control form-control-sm"  name="position" id="position" value="{{ old('position', $user->position) }}" />
                        </div>
                        <button type="submit" form="UpdatePersonalInformationForm" class="btn btn-primary btn-sm">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row justify-content-center">
        <div class="col-md-5">
            <blockquote class="blockquote text-left">
                <p id="SignatureSection" class="mb-0">Signature: </p>
                <footer class="blockquote-footer">
                   This signature will be placed in all print out form when you approve the document. This signature photo must not greater than 512px x 512px
                </footer>
            </blockquote>
        </div>
        <div class="col-md-7">
            <div class="card">     
                <div class="card-body">
                     @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('SignatureSection'))
                        <div class="alert alert-success" role="alert">
                            {{ session('SignatureSection') }}
                        </div>
                    @endif          
                    <form method="POST" action="{{ route('admin.user.signature_image.update', [ 'id' => $user->id ]) }}" enctype="multipart/form-data" novalidate="novalidate" autocomplete="false" id="UpdateSignatureForm">    
                        @csrf
                        @method('PUT')
                        <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" name="approvable" value="1" id="approvable" {{ $user->approvable == 1 ? 'checked' : '' }} }} />
                        <label class="form-check-label" for="approval">Allow user approve the request documents.</label>
                        </div>
                        <input type="file" class="d-none" id="signature_image" name="signature_image">
                        <label class="btn btn-success btn-sm mb-0" for="signature_image">Set/Change Signature</label>   
                        <button type="submit" class="btn btn-primary btn-sm" form="UpdateSignatureForm">Save</button>
                        <div class="d-flex my-2">
                        <img src="{{ $user->signature_image_url }}" alt="User Signature" id="user_signature" class="d-{{ is_null($user->signature_image) ? 'none' : 'block' }}" width="150px">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row justify-content-center">
        <div class="col-md-5">
            <blockquote class="blockquote text-left">
                <p id="PasswordSettingSection" class="mb-0">Password Setting: </p>
                <footer class="blockquote-footer">
                    Protect your user acccount by prodiving strong password [Minimum 8 characters, at least one Uppercase, one Number and one Sepcial Character (!@#$^&*)]
                </footer>
            </blockquote>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.user.password.show', [ 'id' => $user->id ]) }}" class="btn btn-danger btn-sm">Reset Password</a>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row justify-content-center">
        <div class="col-md-5">
            <blockquote class="blockquote text-left">
                <p id="AccountSettingSection" class="mb-0">Account Setting: </p>
                <footer class="blockquote-footer">
                    Account Setting can determine whether the user could log in to system or not.
                </footer>
            </blockquote>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body"> 
                    @if ($errors->hasBag('user_account_setting'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->user_account_setting->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('user_account_setting_status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('user_account_setting_status') }}
                        </div>
                    @endif                  
                    <form method="POST" action="{{ route('admin.user.account_setting.update', [ 'id' => $user->id ]) }}" id="UpdateAccountSettingForm" novalidate="novalidate" autocomplete="false">
                        @csrf                                            
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="verified" value="1" id="verified" {{ $user->verified ? 'checked' : '' }} />
                            <label class="form-check-label" for="verified">Account does not need to be verified.</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="active" value="1" id="active" {{ $user->active ? 'checked' : '' }}/>                            
                            <label class="form-check-label" for="active">Make account as active.</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm" form="UpdateAccountSettingForm">Update Account Setting</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row justify-content-center">
        <div class="col-md-5">
            <blockquote class="blockquote text-left">
                <p id="RoleAndPermissionSection" class="mb-0">User Role</p>
                <footer class="blockquote-footer">
                    Specific role has specific functionlities and limitation. Please be sure the role is assigned to user correctly.
                </footer>
            </blockquote>
        </div>
        <div class="col-md-7">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('role_and_permission'))
                <div class="alert alert-success" role="alert">
                    {{ session('role_and_permission') }}
                </div>
            @endif  
            <form method="POST" action="{{ route('admin.user.role_and_permission.update', [ 'id' => $user->id ]) }}" id="UpdateRoleAndPermissionForm" novalidate="novalidate" autocomplete="false">
            @csrf
            @method('PUT')
            <div class="card mb-3">
                <div class="card-body">  
                    <div class="form-group">
                        <label for="role">Role: </label>
                        <select class="form-control form-control-sm" name="role" id="role" >
                            @foreach( $roles as $role ) 
                            <option value="{{ $role->id }}" data-role="{{ $role->name }}" {{ ( $user->roles->contains($role) ) ? 'selected' : '' }}>{{ str_replace('_',' ',title_case($role->name)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="card mb-3 d-none optional-card" id="managed-by-card">
                <div class="card-body">  
                    <div class="form-group">
                        <label for="role">Managed By:</label>
                        <input type="hidden" id="managedBy" value="{{ old('managed_by') ?? $user->managed_by }}">
                        <select class="form-control form-control-sm" name="managed_by">
                        </select>
                    </div>
                </div>
            </div>

            <div class="card mb-3 d-none optional-card" id="manage-project-card">
                <div class="card-body">  
                    <div class="form-group">
                        <label for="role">Manage Project:</label>
                        @foreach( $projects as $project )
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="projects[]" id="project-{{ $project->id }}" 
                                value="{{ $project->id }}" 
                                {{ ($user->manageProjects->contains($project)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="project-{{ $project->id }}">
                            {{ $project->name }} - {{ $project->name_en }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mb-3 d-none optional-card" id="manage-zone-card" style="max-height: 350px; overflow-y: auto;">
                <div class="card-body">  
                    <div class="form-group">
                        <label for="role">Manage Zones:</label>
                    @foreach( $projects as $project )
                        <p class="font-weight-bold mb-1">{{ $project->name_en }}</p>
                        @foreach( $project->zones->chunk(4) as $chunk )
                        <div class="row">
                            @foreach($chunk as $zone)
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                        name="zones[]" id="zone-{{ $zone->id }}" value="{{ $zone->id }}"
                                        {{ ($user->manageZones->contains($zone)) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="zone-{{ $zone->id }}">
                                    {{ $zone->name }}
                                    </label>
                                </div>
                            </div>                           
                            @endforeach
                        </div>
                        @endforeach
                    @endforeach
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-sm" form="UpdateRoleAndPermissionForm">Update Role Permission</button>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready( function () {
        $('#role').change(function () {
            var selectedRole = $(this).children("option:selected").data('role');     
            $.each( $('.optional-card'), function ( i, val ){ $(val).addClass('d-none'); })       
            switch(selectedRole) {
                case 'site_manager':
                    $("#manage-project-card").removeClass('d-none');
                    break;
                case 'site_engineer':
                    getSiteManagers();                   
                    $("#managed-by-card").removeClass('d-none');
                    $("#manage-zone-card").removeClass('d-none');
                    break;    
                case 'agent':
                    getSaleTeamLeaders();                   
                    $("#managed-by-card").removeClass('d-none');
                    break;
                case 'handover_officer':
                    $("#manage-project-card").removeClass('d-none');
                default:
                    break;
            }
        });

        $('input[type="file"][name="avatar"]').change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#user_avatar').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);
            }
        });

        $('input[type="file"][name="signature_image"]').change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#user_signature').attr('src', e.target.result);
                    $('#user_signature').removeClass('d-none');
                    $('#user_signature').removeClass('d-block');
                }

                reader.readAsDataURL(this.files[0]);
            }
        })

        function getSaleTeamLeaders()  {
            const managed_by_element = $('select[name="managed_by"]');
            const managedBy = $('#managedBy').val();
            axios.get('/api/users/roles/sale_team_leader')
            .then( function (response) { 
                clearManagedByItems();
                response.data.data.filter(function (obj) {              
                    if ( managedBy == obj.id )   {
                        managed_by_element.append(`<option value="${obj.id}" selected>${obj.name}</option>`);
                    } else {
                        managed_by_element.append(`<option value="${obj.id}">${obj.name}</option>`);
                    }
                    
                });
            });
        }

        function getSiteManagers()  {
            const managed_by_element = $('select[name="managed_by"]');
            const managedBy = $('#managedBy').val();
            axios.get('/api/users/roles/site_manager')
            .then( function (response) { 
                clearManagedByItems();
                response.data.data.filter(function (obj) {              
                    if ( managedBy == obj.id )   {
                        managed_by_element.append(`<option value="${obj.id}" selected>${obj.name}</option>`);
                    } else {
                        managed_by_element.append(`<option value="${obj.id}">${obj.name}</option>`);
                    }
                    
                });
            });
        }

        function clearManagedByItems() {
            $('select[name="managed_by"]').empty();
        }

        $('#role').trigger('change');
    });
</script>
@endpush
