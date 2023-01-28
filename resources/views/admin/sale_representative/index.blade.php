@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.sale_representatives.index') }}" name="user-search-from" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                           {{ __("Sale Representatives") }} {{ __('List') }} : <a href="{{route('admin.sale_representatives.create')}}" class="btn btn-primary btn-sm ">{{ __("Create New") }} {{ __("Sale Representatives") }}</a>
                        </div>
                        <div class="col-sm-12 col-md-auto" style="width:400px;">                           
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Name, Short Code ..." aria-label="Name, email or phone number" aria-describedby="button-search" name="term" value="{{ Request::query('term') ? Request::query('term') : '' }}">
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
                            <div class="input-group input-group-sm col-md-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="status">Unit Type:</label>
                                </div>                                  
                                <select class="form-control" name="status" id="status">
                                    <option value="all" {{ Request::query('status') == 'all' ? 'selected' : '' }}>All</option>
                                    <option value="active" {{ Request::query('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="removed" {{ Request::query('status') == 'removed' ? 'selected' : '' }}>Removed</option>
                                </select>
                            </div>                             
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
                                <th scope="col">Name</th>         
                                <th scope="col" width="150px">National ID</th>                     
                                <th scope="col" width="100px">Gender</th>
                                <th scope="col" width="150px">Birth Date</th>                               
                                <th scope="col" width="150px">Created By</th>
                                <th scope="col" width="170px">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale_representatives as $sr)  
                            <tr>
                                <td scope="row" class="action-td">
                                    <a href="{{ route('admin.sale_representatives.edit',['id'=>$sr->id]) }}" class="title">{{ $sr->name }} {{ $sr->name_en ? ' | '.$sr->name_en : ''  }}</a>
                                    @include('admin.sale_representative.action')
                                </td> 
                                <td>
                                    <ul class="mb-0 text-couple">                                       
                                        <li>
                                            <p>
                                                <small>No:</small>
                                                <span class="title">{{ $sr->national_id }}</span>
                                            </p>                                            
                                        </li>
                                        <li>
                                            <p>
                                                <small>Issued Date:</small>
                                                <span class="title">{{ $sr->national_id_issued_date->toDateString() }}</span>
                                            </p>
                                        </li>
                                    </ul>
                                </td>                             
                                <td>{{ $sr->genderKh }}</td>
                                <td>{{ $sr->birth_date->toDateString() }}</td>
                                <td>{{ $sr->createdBy->name }}</td>
                                <td>
                                    <ul class="mb-0 text-couple">                                       
                                        <li>
                                            <p>
                                                <small>Created At:</small>
                                                <span class="title">{{ $sr->created_at }}</span>
                                            </p>                                            
                                        </li>
                                        <li>
                                            <p>
                                                <small>Updated At:</small>
                                                <span class="title">{{ $sr->updated_at }}</span>
                                            </p>
                                        </li>
                                    </ul>
                                </td>
                            </tr>                      
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            </form>
            {{ $sale_representatives->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>
@endsection
