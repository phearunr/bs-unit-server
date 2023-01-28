@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">     
    <form method="POST" action="{{ route('site_manager.site_engineers.store') }}" enctype="multipart/form-data" novalidate="novalidate" autocomplete="false">    
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
            <div class="col-md-12">
                <blockquote class="blockquote text-left">
                    <p class="mb-0">Manage Zone</p>
                    <footer class="blockquote-footer">
                        Assign Zone for Site Engineer.
                    </footer>
                </blockquote>
            </div>
        </div> 

        <div class="row justify-content-center">   
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @foreach( $projects as $project )
                        <p class="font-weight-bold">{{ $project->name }} - {{ $project->name_en }}</p>
                            @foreach( $project->zones->chunk(6) as $chunk )
                                <div class="row">
                                @foreach( $chunk as $zone )
                                <div class="col-md-2">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="zones[]" value="{{ $zone->id }}" class="form-check-input" id="zone-{{ $zone->id }}">
                                        <label class="form-check-label" for="zone-{{ $zone->id }}">{{ $zone->name }}</label>
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

        <hr>

        <button type="submit" class="btn btn-primary float-right mb-5">Create</button>
    </form> 
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
