@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="" name="user-search-from" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            Sub Constructor List : <a href="{{ route('sub_constructors.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> New</a>
                        </div>
                        <div class="col-sm-12 col-md-auto" style="width:400px;">                           
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Name or phone number" aria-label="Name, email or phone number" aria-describedby="button-search" name="term" value="{{ Request::query('term') ? Request::query('term') : '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" id="search-button">Search</button>
                                     <a class="btn btn-outline-secondary" data-toggle="collapse" href="#sub-header-collapse">{{ __("More Filter") }}</a>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover table-action mb-0">
                        <thead>
                            <tr>
                                <th scope="col" width="60px"></th>
                                <th scope="col">Name</th>
                                <th scope="col" width="120px">No. Units</th>
                                <th scope="col" width="120px">No. Worker</th>
                                <th scope="col" width="200px">Contact</th>
                                <th scope="col">Skill</th>
                                <th scope="col">Created By</th>
                                <th scope="col" width="30px"></th>
                            </tr>
                        </thead>
                        @foreach($sub_constructors as $sub_constructor)
                            <tr>
                                <td>
                                    <img src="{{ $sub_constructor->avatar_url }}" alt="{{ $sub_constructor->name }}" class="user-avatar-50">
                                </td>
                                <td class="action-td">
                                    <a href="{{ route('sub_constructors.edit', ['id' => $sub_constructor->id]) }}" class="title d-block">
                                        {{ $sub_constructor->name }}
                                    </a>
                                    <small class="text-muted">Join Date: {{ $sub_constructor->join_date->toSystemDateString() }}</small>
                                </td>
                                <td>
                                    <a href="{{route('sub_constructors.units.index', ['id' => $sub_constructor->id]) }}">
                                        {{ number_format($sub_constructor->units_count, 0) }}
                                    </a>
                                </td>
                                <td>
                                    {{ $sub_constructor->worker }} 
                                </td>
                                <td>
                                    @if( $contact = $sub_constructor->contacts->first() )
                                        <small class="d-block">{{$contact->display_type}}</small>
                                        {{ $contact->value }}
                                    @endif

                                    @if( $sub_constructor->contacts_count >= 2 ) 
                                        <a href="{{ route('sub_constructors.edit', ['id' => $sub_constructor->id]) }}" class="d-block">
                                            <small>{{ $sub_constructor->contacts_count - 1 }} more</small>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if( $skill = $sub_constructor->skills->first() )                                      
                                    {{ $skill->name_km }} <small class="d-block">{{$skill->name}}</small>
                                    @endif

                                    @if( $sub_constructor->skills_count >= 2 ) 
                                    <a href="{{ route('sub_constructors.edit', ['id' => $sub_constructor->id]) }}" class="d-block">
                                        <small>{{ $sub_constructor->skills_count - 1 }} more</small>
                                    </a>
                                    @endif
                                </td>
                                <td>
                                    <span class="d-block">{{ $sub_constructor->createdBy->name }}</span>
                                    <small class="text-muted d-block">Created At: {{ $sub_constructor->created_at }}</small>
                                    <small class="text-muted d-block">Updated At: {{ $sub_constructor->updated_at }}</small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="text-primary" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-lg fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left" aria-labelledby="dropdownMenuButton">
                                            <a href="{{route('sub_constructors.edit', ['id' => $sub_constructor->id]) }}" class="dropdown-item">
                                                {{__("Edit")}}
                                            </a>
                                            <a href="{{route('sub_constructors.units.index', ['id' => $sub_constructor->id]) }}" class="dropdown-item">
                                                {{__("Assign Unit")}}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                    </table>
                </div>
            </div>
            </form>
            {{ $sub_constructors->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush