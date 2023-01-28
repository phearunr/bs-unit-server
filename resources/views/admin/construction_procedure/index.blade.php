@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.construction_procedures.index') }}" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                           {{ __("Construction Procedure List") }} : <a href="{{route('admin.construction_procedures.create')}}" class="btn btn-primary btn-sm ">{{ __("Create New") }} {{ __("Construction Procedure") }}</a>
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
                                <th scope="col" width="150px">Created By</th>
                                <th scope="col" width="170px">Timestamp</th>
                                <th width="30px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($construction_procedures as $construction_procedure)   
                            <tr>
                                <td>
                                    <span class="d-block"><strong>{{ $construction_procedure->name_km }}</strong></span>
                                    <span class="d-block">{{ $construction_procedure->name }}</span>
                                </td>
                             
                                <td>
                                   {{ $construction_procedure->createdBy->name }}
                                </td>
                                <td>
                                    <ul class="mb-0 text-couple">                                       
                                        <li>
                                            <p>
                                                <small>{{ __('Created At') }}:</small>
                                                <span class="title">{{ $construction_procedure->created_at }}</span>
                                            </p>                                            
                                        </li>
                                        <li>
                                            <p>
                                                <small>{{ __('Updated At') }}:</small>
                                                <span class="title">{{ $construction_procedure->updated_at }}</span>
                                            </p>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="#" class="text-primary" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false"><i class="fas fa-lg fa-ellipsis-v"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                                            <a href="{{ route('admin.construction_procedures.edit', ['id'=>$construction_procedure->id]) }}" class="dropdown-item">{{ __("Edit") }}</a>                                        
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
            {{ $construction_procedures->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>
@endsection
