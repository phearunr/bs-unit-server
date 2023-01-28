@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.banners.index') }}" name="user-search-from" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                           {{ __("Banner") }} {{ __('List') }} : <a href="{{route('admin.banners.create')}}" class="btn btn-primary btn-sm ">{{ __("Create New") }} {{ __("Banner") }}</a>
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
                                <th scope="col" width="100px"></th>
                                <th scope="col">{{ __("Url") }}</th>
                                <th scope="col">{{ __("Order") }}</th>
                                <th scope="col" width="170px">{{ __("Expiration Date") }}</th>
                                <th scope="col" width="30px"></th>
                            </tr>
                        </thead>
                        <tbody>          
                        @foreach( $banners as $banner )     
                            <tr>
                                <td><img src="{{ $banner->image_thumbnail_url }}" width="100px"></td>
                                <td><a href="{{ $banner->url }}">{{ $banner->url }}</a></td>
                                <td>{{ $banner->order }}</td>
                                <td>
                                    @if($banner->isExpired())
                                        <i class="fas fa-times-circle text-danger"></i>                                        
                                    @else
                                        <i class="fas fa-check-circle text-success"></i>
                                    @endif
                                    {{ $banner->expired_at->toSystemDateString() }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="#" class="text-primary" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false"><i class="fas fa-lg fa-ellipsis-v"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                                            <a href="{{ route('admin.banners.edit', ['id'=>$banner->id]) }}" class="dropdown-item">{{ __("Edit") }}</a>
                                            <a href="#" data-id="{{ $banner->id }}" class="dropdown-item delete-button">{{ __("Remove") }}</a>
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
            {{ $banners->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).on('click','.delete-button', function(e){
        var obj = $(e.target);
        var id = obj.data('id');        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            preConfirm: () => {            
                return axios.post(`/admin/banners/${id}`, {
                    _method : "DELETE"
                })
                .then(function (response) {   
                    if ( response.status >= 200 && response.status < 300) {
                        obj.closest('tr').remove();
                    }
                }) 
                .catch(error => {                    
                    if ( error.response.status == 404 ) {
                        Swal.showValidationMessage(
                            `${error.response.data.message}`
                        )
                    } else {
                        Swal.showValidationMessage(
                            `${error}`
                        )
                    }   
                });
            }
        })
    });
</script>
@endpush