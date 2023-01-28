@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.site_engineers.index') }}" name="user-search-from" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            Site Engineer List : <a href="{{route('admin.site_engineers.create')}}" class="btn btn-primary btn-sm ">Create New Site Engineer</a>
                        </div>
                        <div class="col-sm-12 col-md-auto" style="width:400px;">                           
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Name, email or phone number" aria-label="Name, email or phone number" aria-describedby="button-search" name="term" value="{{ Request::query('term') ? Request::query('term') : '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" id="search-button">Search</button>
                                    <a class="btn btn-outline-secondary" data-toggle="collapse" href="#sub-header-collapse">{{ __("More Filter") }}</a>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="card-sub-header card-bg-grey collapse {{ Request::query() ? 'show' : '' }}" id="sub-header-collapse">
                    <div class="sub-header-box-wrapper">
                        <div class="form-row">
                            <div class="input-group input-group-sm col-md-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="role_select">Role</label>
                                </div>
                                <input type="text" id="name" readonly="readonly" value="Site Engineer" class="form-control">
                                
                            </div>                          
                            <div class="input-group input-group-sm col-md-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="active">{{ __("Active?") }}</label>
                                </div>
                                <select class="form-control" name="active" id="active">
                                    <option value="">{{ __("All") }}</option>
                                    <option value="true" {{ Request::query('active') == 'true' ? 'selected' : '' }}>{{ __("Yes") }}</option>
                                    <option value="false" {{ Request::query('active') == 'false' ? 'selected' : '' }}>{{ __("No") }}</option>
                                </select>
                            </div>
                            <div class="input-group input-group-sm col-md-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="verified">{{ __("Verified?") }}</label>
                                </div>
                                <select class="form-control" name="verified" id="verified">
                                    <option value="">{{ __("All") }}</option>
                                    <option value="true" {{ Request::query('verified') == 'true' ? 'selected' : '' }}>{{ __("Yes") }}</option>
                                    <option value="false" {{ Request::query('verified') == 'false' ? 'selected' : '' }}>{{ __("No") }}</option>
                                </select>
                            </div>
                            <button class="btn btn-sm btn-primary" type="submit" id="filter-button">Show</button>    
                            <a href="{{ route('admin.site_engineers.index') }}" class="btn btn-secondary btn-sm ml-md-2">Clear Filter</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover table-action mb-0">
                        <thead>
                            <tr>
                                <th scope="col" width="60px"></th>
                                <th scope="col">Name</th>
                                <th scope="col" width="150px">{{ __("Phone Number") }}</th>
                                <th scope="col" width="100px">{{ __("Gender") }}</th>
                                <th scope="col" width="70px">{{ __("Active") }}</th>
                                <th scope="col" width="70px">{{ __("Verified") }}</th>                                
                                <th scope="col" width="150px">{{ __("Member Since") }}</th>
                                <th scope="col" width="30px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td scope="row">
                                    <img src="{{ $user->avatar_url }}" class="user-avatar-50" alt="{{ $user->name }}">
                                </td>
                                <td class="action-td">
                                    <a href="{{ route('admin.site_engineers.show',['id'=>$user->id]) }}" class="title" >{{ $user->name }}</a>
                                    <span class="d-block text-muted">
                                        @if( isset($user->roles[0]) )
                                        {{ str_replace('_',' ', title_case($user->getRoleNames()[0]) )}}
                                        @else
                                        N/A
                                        @endif
                                    </span>
                                </td>
                                <td><b>{{ $user->phone_number }}</b></td>
                                <td>{{ $user->gender }}</td>
                                <td>{!! $user->getActiveHtml() !!}</td>
                                <td>{!! $user->getVerifiedHtml() !!}</td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="text-primary" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-lg fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left" aria-labelledby="zdropdownMenuButton">
                                            <a href="{{ route('admin.site_engineers.show', [ 'id' => $user->id ] ) }}" class="dropdown-item">
                                                {{__("View")}}
                                            </a>
                                            <a href="{{ route('admin.site_engineers.edit', [ 'id' => $user->id ] ) }}" class="dropdown-item">
                                                {{__("Edit")}}
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
            {{ $users->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush