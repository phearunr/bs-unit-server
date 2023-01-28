@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">     
    <form method="POST" action="{{ route('admin.user.store') }}" enctype="multipart/form-data" novalidate="novalidate" autocomplete="false">    
        @csrf
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
                        <img src="https://ui-avatars.com/api/?name=User avatar&background=00b4ff&color=fff&rounded=true" alt="user avatar" id="user_avatar" class="rounded-circle d-block" width="80px">
                        <span class="text-muted font-italic"><small>Profile image should be sqaure and not greater than 512px x 512px</small></span>
                        <div class="my-2">
                            <input type="file" class="d-none" id="avatar" name="avatar">
                            <label class="btn btn-primary btn-sm mb-0" for="avatar">Set User Image</label>                     
                        </div>
                        <div class="form-group">
                            <label for="name">Full Name:</label>
                            <input type="text" class="form-control form-control-sm" name="name" id="name" value="{{ old('name') }}" />
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select class="form-control form-control-sm" name="gender" id="gender">                          
                                <option value="Male" {{ old("gender") == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old("gender") == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="birthdate">Date of Birth: <span class="text-muted">(format: {{ config('app.js_date_format') }})</span></label>
                            <input type="text" class="form-control form-control-sm datepicker" name="birthdate" value="{{ old('birthdate') }}">                           
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number: </label>
                            <input type="text" class="form-control form-control-sm" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" />                                      
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address: </label>
                            <input type="email" class="form-control form-control-sm"  name="email" id="email" value="{{ old('email') }}" />
                        </div>
                        <div class="form-group">
                            <label for="department_id">Department: </label>
                            <select class="form-control form-control-sm" name="department_id" id="department_id" >
                                <option value="">None</option>
                                @foreach(\App\Department::all() as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="position">Position: </label>
                            <input type="text" class="form-control form-control-sm"  name="position" id="position" value="{{ old('position') }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row justify-content-center">
            <div class="col-md-5">
                <blockquote class="blockquote text-left">
                    <p class="mb-0">Password Setting: </p>
                    <footer class="blockquote-footer">
                        Protect your user acccount by prodiving strong password [Minimum 8 characters, at least one Uppercase, one Number and one Sepcial Character (!@#$^&*)]                       
                    </footer>
                </blockquote>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">  
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control form-control-sm" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password:</label>
                            <input type="password" class="form-control form-control-sm" name="password_confirmation" id="password_confirmation"/>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="need_change_password" value="1" name="need_change_password" checked/>
                            <label class="form-check-label" for="need_change_password">Force user to change password when he/she log in</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row justify-content-center">
            <div class="col-md-5">
                <blockquote class="blockquote text-left">
                    <p class="mb-0">Account Setting: </p>
                    <footer class="blockquote-footer">
                        Account Setting can determine whether the user could log in to system or not.                
                    </footer>
                </blockquote>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="verified" value="1" id="verified" checked/>
                            <label class="form-check-label" for="verified">Account does not need to be verified.</label>
                        </div>
                        <div class="form-group form-check mb-0">
                            <input type="checkbox" class="form-check-input" name="active" value="1" id="active" checked/>                            
                            <label class="form-check-label" for="active">Make account as active.</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row justify-content-center">
            <div class="col-md-5">
                <blockquote class="blockquote text-left">
                    <p class="mb-0">User Role</p>
                    <footer class="blockquote-footer">
                        Specific role has specific functionlities and limitation. Please be sure the role is assigned to user correctly.
                    </footer>
                </blockquote>
            </div>
            <div class="col-md-7">
                <div class="card mb-3">
                    <div class="card-body">  
                        <div class="form-group">
                            <label for="role">Role: </label>
                            <select class="form-control form-control-sm" name="role" id="role" >
                                @foreach( $roles as $role ) 
                                <option value="{{ $role->id }}" data-role="{{ $role->name }}">{{ str_replace('_',' ',title_case($role->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-3 d-none optional-card" id="managed-by-card">
                    <div class="card-body">  
                        <div class="form-group">
                            <label for="role">Managed By:</label>
                            <select class="form-control form-control-sm" name="managed_by">
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card mb-3 d-none optional-card" id="manage-project-card">
                    <div class="card-body">  
                        <div class="form-group">
                            <label for="role">Manage Projects:</label>
                            @foreach( $projects as $project )
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="projects[]" id="project-{{ $project->id }}" value="{{ $project->id }}">
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
                                        <input class="form-check-input" type="checkbox" name="zones[]" id="zone-{{ $zone->id }}" value="{{ $zone->id }}">
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
            </div>
        </div>

        <hr>

        <button type="submit" class="btn btn-primary float-right mb-5">Create</button>
    </form> 
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready( function () {
        $('#role').change(function () {
            var selectedRole = $(this).children("option:selected").data('role');         
            $.each( $('.optional-card'), function ( i, val ){ $(val).addClass('d-none'); });
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
                    break;
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

        function getSiteManagers() {
            const managed_by_element = $('select[name="managed_by"]');
            axios.get('/api/users/roles/site_manager')
            .then( function (response) { 
                clearManagedByItems();
                response.data.data.filter(function (obj) {                 
                    managed_by_element.append(`<option value="${obj.id}">${obj.name}</option>`);
                });
            });
        }

        function clearManagedByItems() {
            $('select[name="managed_by"]').empty();
        }
    });
</script>
@endpush
