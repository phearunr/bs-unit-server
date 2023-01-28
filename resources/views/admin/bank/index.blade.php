@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.banks.index') }}" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                           {{ __("Bank List") }} : <a href="{{route('admin.banks.create')}}" class="btn btn-primary btn-sm ">{{ __("Create New") }} {{ __("Bank") }}</a>
                        </div>
                        <div class="col-sm-12 col-md-auto" style="width:400px;">                           
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Name, Short Code ..." aria-label="Name, email or phone number" aria-describedby="button-search" name="term" value="{{ Request::query('term') ? Request::query('term') : '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" id="search-button">Search</button>                                   
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
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col" width="200px">{{ __('Account Name') }}</th>                                
                                <th scope="col" width="200px">{{ __('Account Number') }}</th>
                                <th scope="col" width="170px">Timestamp</th>
                                <th width="30px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($banks as $bank)   
                            <tr>
                                <td>
                                    <span class="d-block"><strong>{{ $bank->name }}</strong></span>
                                    <span class="d-block"><small>{{ $bank->short_name }}</small></span>
                                </td>                               
                                <td>{{ $bank->account_name }}</td>
                                <td>{{ $bank->account_number }}</td>                               
                                <td>
                                    <ul class="mb-0 text-couple">                                       
                                        <li>
                                            <p>
                                                <small>{{ __('Created At') }}:</small>
                                                <span class="title">{{ $bank->created_at }}</span>
                                            </p>                                            
                                        </li>
                                        <li>
                                            <p>
                                                <small>{{ __('Updated At') }}:</small>
                                                <span class="title">{{ $bank->updated_at }}</span>
                                            </p>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="#" class="text-primary" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false"><i class="fas fa-lg fa-ellipsis-v"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                                            <a href="{{ route('admin.banks.edit', ['id'=>$bank->id]) }}" class="dropdown-item">{{ __("Edit") }}</a>
                                            <a href="#" data-id="{{ $bank->id }}" class="dropdown-item delete-button">{{ __("Remove") }}</a>
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
            {{ $banks->appends(request()->except(['page','_token'])) }}
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
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            preConfirm: () => {            
                return axios.post(`/admin/banks/${id}`, {
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
