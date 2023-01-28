@extends('layouts.app')

@section('styles')
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="list-group">
                <li class="list-group-item active">
                    <span>Notifications</span>
                    <a href="{{ route('admin.notification.mark.read.all') }}" class="btn btn-sm btn-success float-right">{{ __("Mark all as read") }}</a>
                </li>
                @foreach( Auth::user()->notifications()->simplePaginate(10) as $notification )
                    @include('admin.notification.template.'.snake_case(class_basename($notification->type)))
                @endforeach
            </div>
        </div>        
    </div>
</div>
@endsection
