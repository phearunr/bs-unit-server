@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User : {{ $user->name }}</div>
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
                    <form method="POST" action="{{ route('admin.user.update', ['id'=> $user->id]) }}" novalidate="novalidate" autocomplete="false">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="User Fullname" value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="email">Email: </label>
                                    <input type="email" class="form-control" 
                                           name="email" 
                                           id="email" 
                                           placeholder="Email Address : yourname@yourdomain.com"
                                           value="{{ $user->email }}">
                                </div>  
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Phone Number: <span class="text-danger">*</span> <span class="text-muted">used for login</span></label>
                                    <input type="text" class="form-control" 
                                           name="phone_number" id="phone_number" 
                                           placeholder="0123456789"
                                           value="{{ $user->phone_number }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">Gender: </label>
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="0" {{ $user->gender ? "selected" : "" }}>N/A</option>
                                        <option value="Male" {{ $user->gender == "Male" ? "selected" : ""}}>Male</option>
                                        <option value="Female" {{ $user->gender == "Female" ? "selected" : ""}}>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="verified" id="verified" {{ $user->verified ? 'checked' : '' }}>
                            <label class="form-check-label" for="verified">{{ __("Account does not need to be verified.") }}</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="active" id="active" {{ $user->active ? 'checked' : '' }}>                            
                            <label class="form-check-label" for="active">{{ __("Make account as active. (Inactive account will not be able to use the application.)") }}</label>
                        </div>

                        <div class="form-group">
                            <label for="managed_by">Managed By: </label>
                            <select class="form-control" name="managed_by" id="managed_by">
                                <option value="0">N/A</option>
                                @foreach( $users as $u )
                                <option value="{{$u->id}}" {{ ( $user->managed_by == $u->id ? "selected" : "" ) }}>{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="role">Role: </label>
                            <select class="form-control" name="role" id="role">
                                @foreach( $roles as $role )
                                <option value="{{$role->id}}" {{ ( $user->hasRole($role) ? "selected" : "" ) }}>{{ str_replace('_',' ',title_case($role->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <p class="text-info">**Change the user's Phone Number will remove all login session in mobile app.</p>

                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.user.all') }}" class="btn btn-secondary float-right">Back to User List</a> 
                                <a href="{{ route('admin.user.password.show',['id'=>$user->id]) }}" class="btn btn-danger float-right mx-2">{{ __('Reset Password') }}</a>                                  
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
