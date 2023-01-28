@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Role : Edit New Role</div>
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
                    <form method="POST" action="{{ route('admin.role.update', ['id'=>$role->id]) }}" novalidate="novalidate" autocomplete="false">
                        @csrf    
                        {{ method_field('PUT') }}    
                        <div class="form-group">
                            <label for="name">Name: <span class="text-danger">*</span> <span class="text-muted">Please use _ instead of space. No capital letter</span></label>
                            <input type="text" class="form-control" id="name"  readonly="readonly"
                                   placeholder="Eg. sale_manager, unit_controller, agent" 
                                   value="{{ $role->name }}">
                        </div>
                        <div class="form-group">
                            <label for="guard">Guard: </label>
                            <select class="form-control" name="guard" id="guard">
                                @foreach( $guards as $guard )
                                <option value="{{ $guard }}">{{ $guard }}</option>
                                @endforeach
                            </select>
                        </div>
                        <h5>Permissions</h5>
                        <hr>
                                                  
                        @include('admin.role.partial.permission', [ 'permissions' => $permissions, 'role_have_permission' => $role_have_permission])
                       
                        <hr>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Update Role</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.role.all') }}" class="btn btn-secondary float-right">Back to Role List</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
