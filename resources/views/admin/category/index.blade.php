@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.categories.index') }}" name="user-search-from" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                           {{ __("Category") }} {{ __('List') }} : <a href="{{route('admin.categories.create')}}" class="btn btn-primary btn-sm ">{{ __("Create New") }} {{ __("Category") }}</a>
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
                                <th scope="col">{{ __('Name') }}</th>
                                <th width="130px">{{ __('System Default') }}</th>
                                <th width="100px">{{ __('Post Count') }}</th>
                                <th width="170px">{{ __('Timestamp') }}</th>
                                <th width="30px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $cat)    
                            <tr>                                
                                <td scope="row">
                                    <a class="title" href="{{ route('admin.categories.edit', ['id'=>$cat->getKey()]) }}">{{ $cat->name }}</a>
                                    <span class="text-muted d-block"><i>{{ $cat->description }}</i></span>
                                </td>
                                <td>
                                    @if ($cat->default)
                                        <i class="fas fa-check-circle text-success"></i>
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i>
                                    @endif
                                </td>
                                <td>
                                    {{ $cat->posts_count }}
                                </td>
                                <td>
                                    <ul class="mb-0 text-couple">                                       
                                        <li>
                                            <p>
                                                <small>{{ __('Created At') }}:</small>
                                                <span class="title">{{ $cat->created_at }}</span>
                                            </p>                                            
                                        </li>
                                        <li>
                                            <p>
                                                <small>{{ __('Updated At') }}:</small>
                                                <span class="title">{{ $cat->updated_at }}</span>
                                            </p>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <div class="dropdown dropleft">
                                        <a href="#" class="text-primary" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false"">
                                            <i class="fas fa-lg fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left" aria-labelledby="dropdownMenuButton">
                                            <a href="{{ route('admin.categories.edit',['id'=>$cat->id]) }}" class="dropdown-item">
                                                {{__("Edit")}}
                                            </a>
                                            <a href="#" data-id="{{ $cat->id }}" class="dropdown-item delete-category">
                                                {{__("Remove")}}
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
            {{ $categories->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('.delete-category').on('click', function(e) {
            var id = $(e.target).data('id');
            if ( id != undefined ) {                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,                   
                    confirmButtonText: 'Yes, delete it!',
                    preConfirm: () => {                        
                        const url = `/admin/categories/${id}`;                     
                        axios.post(url, {                      
                            _method : 'DELETE'
                        })
                        .then(function (response) {
                            if ( response.status >= 200 && response.status < 300 ) {
                                Swal.fire(
                                    'Successful',
                                    response.data.message,
                                    'success'
                                ).then( function () {
                                    location.reload();
                                });
                            } else {
                                alert(response.data.message);
                            }
                        })
                        .catch(function (error) {
                            if (error.response.status == 404) {
                                Swal.fire(
                                    'Not Found',
                                    'The resource you has requested is not available.',
                                    'error'
                                );    
                            } else {
                                Swal.fire(
                                    'Error',
                                    error.response.data.message,
                                    'error'
                                );    
                            }     
                        });
                    }
                })
            }           
        });
    });
</script>
@endpush