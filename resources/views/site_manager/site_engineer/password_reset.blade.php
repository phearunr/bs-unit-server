@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User : Reset Password</div>
                <div class="card-body">
                    <h4>User : {{ $user->name }}</h4>
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
                    
                    <form method="POST" action="{{ route('site_manager.site_engineers.password.reset', ['id'=>$user->id]) }}" novalidate="novalidate" autocomplete="false">
                        @csrf
                        <div class="form-group">
                            <label for="password">New Password</label><br>
                            <!-- <span class="text-muted font-italic"><small>Password must be storng</small></span> -->
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="need_change_password" id="need_change_password" checked>
                            <label class="form-check-label" for="need_change_password">Force user to change password when he/she log in</label>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Reset</button>
                            </div>
                            <div class="col">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary float-right">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
