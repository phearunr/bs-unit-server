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
                    @if ($errors->hasBag('site_engineer_profile_information'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->site_engineer_profile_information->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('site_engineer_profile_information_status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('site_engineer_profile_information_status') }}
                        </div>
                    @endif 
                    <form method="POST" action="{{ route('site_manager.site_engineers.personal_information.update', [ 'id' => $user->id ]) }}" enctype="multipart/form-data" novalidate="novalidate" autocomplete="false" id="UpdatePersonalInformationForm">    
                        @csrf
                        @method('PUT')
                        <img src="{{ $user->avatar_url }}" alt="user avatar" id="user_avatar" class="rounded-circle d-block" width="80px">
                        <span class="text-muted font-italic"><small>Profile image should be sqaure and not greater than 512px x 512px</small></span>
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
                            <input type="email" class="form-control form-control-sm"  name="email" id="email" value="{{ old('email') ?? $user->email }}" />
                        </div>                      
                        <div class="form-group">
                            <label for="position">Position: </label>
                            <input type="text" class="form-control form-control-sm"  name="position" id="position" value="{{ old('position') ?? $user->position }}" />
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
                <p id="PasswordSettingSection" class="mb-0">Password Setting: </p>
                <footer class="blockquote-footer">
                    Protect your user acccount by prodiving strong password [Minimum 8 characters, at least one Uppercase, one Number and one Sepcial Character (!@#$^&*)]
                </footer>
            </blockquote>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('site_manager.site_engineers.password.show', [ 'id' => $user->id ]) }}" class="btn btn-danger btn-sm">Reset Password</a>
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
                    @if ($errors->hasBag('site_engineer_account_setting'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->site_engineer_account_setting->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('site_engineer_account_setting_status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('site_engineer_account_setting_status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('site_manager.site_engineers.account_setting.update', [ 'id' => $user->id ]) }}" id="UpdateAccountSettingForm" novalidate="novalidate" autocomplete="false">
                        @csrf
                        @method('PUT')
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
        <div class="col-md-12">
            <blockquote class="blockquote text-left">
                <p id="ZoneManagementSection" class="mb-0">Manage Zone</p>
                    <footer class="blockquote-footer">
                        Assign Zone for Site Engineer.
                    </footer>
            </blockquote>
        </div>
    </div>
    <div class="row justify-content-center">        
        <div class="col-md-12">
            <div class="card mb-2">
                <div class="card-body" style="max-height: 350px; overflow: auto;">
                    @if ($errors->hasBag('site_engineer_manage_zone_setting'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->site_engineer_manage_zone_setting->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('manage_zone_status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('manage_zone_status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('site_manager.site_engineers.managed_zones.update', [ 'user' => $user->id ]) }}" id="UpdateZoneForm" novalidate="novalidate" autocomplete="false">        
                    @csrf
                    @method('PUT')  
                    @foreach( $projects as $project )
                    <h6 class="text-muted mb-0">{{ $project->name }}</h6>
                    <p class="text-muted">{{ $project->name_en }}</p>
                        @foreach( $project->zones->chunk(6) as $chunk )
                            <div class="row">
                            @foreach( $chunk as $zone )
                            <div class="col-md-2">
                                <div class="form-group form-check">
                                    <input 
                                        type="checkbox" name="zones[]" value="{{ $zone->id }}" class="form-check-input" id="zone-{{ $zone->id }}"
                                        {{ ($user->manageZones->contains($zone)) ? 'checked' : '' }} />
                                    <label class="form-check-label font-weight-bold" for="zone-{{ $zone->id }}">{{ $zone->name }}</label>
                                </div>
                            </div>
                            @endforeach
                            </div>
                        @endforeach
                    @endforeach                   
                    </form>
                </div>
            </div>
             <button type="submit" class="btn btn-primary btn-sm" form="UpdateZoneForm">Update Zone</button>
        </div>
    </div>    
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready( function () {

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
    });
</script>
@endpush
