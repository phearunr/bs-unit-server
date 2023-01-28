@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Role List : <a href="{{route('admin.role.new')}}" class="btn btn-primary btn-sm float-right">Create New Role</a></div>

                <div class="card-body p-0">                  
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table class="table table-hover table-action mb-0">   
                        <thead>
                            <tr>                                
                                <th scope="col" width="80">ID</th>
                                <th scope="col">Role Name</th>
                                <th scope="col">No. Users</th>
                                <th scope="col" width="200px">Key</th>
                                <th scope="col" width="100px">Guard</th>
                                <th scope="col" width="80px"></th>
                            </tr>
                        </thead>              
                        <tbody>
                            @foreach( $roles as $role )
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td class="action-td">
                                    <a href="{{ route('admin.role.edit',['id'=>$role->id]) }}" class="title">
                                        {{ str_replace('_',' ', title_case($role->name))}}
                                    </a>
                                </td>
                                <td><a href="{{ route('admin.user.all',['role'=> $role->id]) }}">{{ $count = $role->users_count }} {{ str_plural('User',$count) }}</a></td>
                                <td>{{ $role->name }}</td>                                
                                <td>{{ $role->guard_name }}</td>
                                <td>
                                    <a href="{{ route('admin.role.remove',['id'=>$role->id]) }}" class="text-danger">
                                        <i class="fas fa-trash-alt" data-toggle="tooltip" data-placement="top" title="{{ __('Remove') }}"></i>
                                    </a>
                                </td>
                            </tr>                    
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
