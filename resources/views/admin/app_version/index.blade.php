@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.app_versions.index') }}" name="user-search-from" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                           {{ __("Mobile App Version") }} {{ __('List') }} : <a href="{{route('admin.app_versions.create')}}" class="btn btn-primary btn-sm ">{{ __("Create New") }} {{ __("Mobile App Version") }}</a>
                        </div>                        
                    </div>                    
                </div>                 
                <div class="card-body p-0">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <table class="table table-hover table-action mb-0">
                        <thead>
                            <tr>                                
                                <th scope="col">{{ __("Platform") }}</th>
                                <th scope="col" width="170px">{{ __("Released Date") }}</th>
                                <th scope="col" width="100px">{{ __("Build No.") }}</th>                     
                                <th scope="col" width="100px">{{ __("Version") }}</th>
                                <th scope="col" width="120px">{{ __("Force Update") }}</th>                               
                                <th scope="col" width="150px">{{ __("Created By") }}</th>
                                <th scope="col" width="170px">{{ __("Timestamp") }}</th>
                                <th scope="col" width="30px"></th>
                            </tr>
                        </thead>
                        <tbody>          
                        @foreach( $app_versions as $app_version )
                            <tr>
                                <td><strong>{{ $app_version->platform }}</strong></td>
                                <td>{{ $app_version->released_at->toSystemDateString() }}</td>
                                <td>{{ $app_version->build }}</td>
                                <td>{{ $app_version->version }}</td>
                                <td>{!! $app_version->getForcedUpdateHtml() !!}</td>
                                <td>{{ $app_version->createdBy->name }}</td>
                                <td>
                                    <ul class="mb-0 text-couple">                                       
                                        <li>
                                            <p>
                                                <small>{{ __("Created At:") }}</small>
                                                <span class="title">{{ $app_version->created_at->toSystemDateTimeString() }}</span>
                                            </p>                                            
                                        </li>
                                        <li>
                                            <p>
                                                <small>{{ __("Updated At:") }}</small>
                                                <span class="title">{{ $app_version->updated_at->toSystemDateTimeString() }}</span>
                                            </p>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="#" class="text-primary" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false"><i class="fas fa-lg fa-ellipsis-v"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                                            <a href="{{ route('admin.app_versions.edit', ['id'=> $app_version->id]) }}" class="dropdown-item">{{ __("Edit") }}</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            </form>
            {{ $app_versions->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>
@endsection
