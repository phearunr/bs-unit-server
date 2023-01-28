@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User : Create New User</div>
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
                    <form method="POST" action="{{ route('admin.user.create') }}" novalidate="novalidate" autocomplete="false">
                        @csrf                      
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="User Fullname" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="email">Email: </label>
                                    <input type="email" class="form-control" 
                                           name="email" 
                                           id="email" 
                                           placeholder="Email Address : yourname@yourdomain.com"
                                           value="{{ old('email') }}">
                                </div>  
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="phone_number">Phone Number: <span class="text-danger">*</span> <span class="text-muted">used for login</span></label>
                                    <input type="text" class="form-control" 
                                           name="phone_number" id="phone_number" 
                                           placeholder="0123456789"
                                           value="{{ old('phone_number') }}">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="gender">Gender: </label>
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="0">N/A</option>
                                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }} >Male</option>
                                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="password">Password: <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" 
                                           name="password" id="password"                                        
                                           value="">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password: <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" 
                                           name="password_confirmation" id="password_confirmation" value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="need_change_password" id="need_change_password" checked>
                            <label class="form-check-label" for="need_change_password">Force user to change password when he/she log in</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="verified" id="verified" checked>
                            <label class="form-check-label" for="verified">{{ __("Account does not need to be verified.") }}</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="active" id="active" checked>                            
                            <label class="form-check-label" for="active">{{ __("Make account as active. (Inactive account will not be able to use the application.)") }}</label>
                        </div>
                        <div class="form-group">
                            <label for="managed_by">Managed By: </label>
                            <select class="form-control select2" name="managed_by" id="managed_by">
                                <option value="0">N/A</option>
                                @foreach( $users as $user )
                                <option value="{{$user->id}}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="role">Role: </label>
                            <select class="form-control" name="role" id="role">
                                @foreach( $roles as $role )
                                <option value="{{$role->id}}">{{ str_replace('_',' ',title_case($role->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <p class="text-info">**Change the user's Phone Number will remove all login session in mobile app.</p>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Create New User</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.user.all') }}" class="btn btn-secondary float-right">Back to User List</a>  
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
