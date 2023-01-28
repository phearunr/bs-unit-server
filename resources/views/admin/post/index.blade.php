@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.posts.index') }}" name="user-search-from" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                           {{ __("Post") }} {{ __('List') }} : <a href="{{route('admin.posts.create')}}" class="btn btn-primary btn-sm ">{{ __("New") }} {{ __("Post") }}</a>
                        </div>
                        <div class="col-sm-12 col-md-auto" style="width:400px;">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="{{ __('Title...')}} " aria-label="Name, email or phone number" aria-describedby="button-search" name="term" value="{{ Request::query('term') ? Request::query('term') : '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" id="search-button">Search</button>
                                    <a class="btn btn-outline-secondary" data-toggle="collapse" href="#sub-header-collapse">More Filter</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="card-sub-header card-bg-grey collapse {{ array_except(Request::query(),'page') ? 'show' : '' }}" id="sub-header-collapse">
                    <div class="sub-header-box-wrapper">
                        <div class="form-row">
                            <button class="btn btn-sm btn-primary" type="submit" id="fileter-button">Show</button>
                            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary btn-sm ml-md-2">Clear Filter</a>
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
                                <th scope="col">{{ __('Title') }}</th>
                                <th width="100px">{{ __('Status') }}</th>
                                <th width="150px">{{ __('Author') }}</th>
                                <th width="170px">{{ __('Publish Date') }}</th>
                                <th width="170px">{{ __('Timestamp') }}</th>
                                <th width="30px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)    
                            <tr>                                
                                <td scope="row">
                                    <a class="title" href="{{ route('admin.posts.edit', ['id'=>$post->getKey()]) }}">{{ $post->title }}</a>
                                    <span class="text-muted d-block"><i>{{ $post->short_description }}</i></span>
                                </td>
                                <td>{{ $post->status }}</td>
                                <td>{{ $post->author->name }}</td>
                                <td>
                                    {{ $post->published_at }}
                                    <span class="text-muted font-italic">{{ $post->published_at->diffForHumans() }}</span>
                                </td>
                                <td>
                                    <ul class="mb-0 text-couple">                                       
                                        <li>
                                            <p>
                                                <small>{{ __('Created At') }}:</small>
                                                <span class="title">{{ $post->created_at }}</span>
                                            </p>                                            
                                        </li>
                                        <li>
                                            <p>
                                                <small>{{ __('Updated At') }}:</small>
                                                <span class="title">{{ $post->updated_at }}</span>
                                            </p>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <div class="dropdown dropleft">
                                        <a href="#" class="text-primary" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-lg fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left" aria-labelledby="dropdownMenuButton">
                                            <a href="{{ route('admin.posts.edit',['id'=>$post->id]) }}" class="dropdown-item">
                                                {{ __("Edit") }}
                                            </a>
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
            {{ $posts->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush