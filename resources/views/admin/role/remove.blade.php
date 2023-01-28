@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Role : Create New Role</div>
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
                    <form method="POST" action="{{ route('admin.role.delete', ['id' => $role->id]) }}" novalidate="novalidate" autocomplete="false">
                        @csrf 
                        {{ method_field('DELETE') }}   
                     
                        <p>Are you sure want to delete role : <b>{{ $role->name }} ?</b></p>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-danger">Yes, delete it</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.role.all') }}" class="btn btn-secondary float-right">No, back to role list</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
