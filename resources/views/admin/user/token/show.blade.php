@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">User : {{ $user->name }}</div>
                <div class="card-body p-0">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('Device Name') }}</th>
                                <th>{{ __('Platform') }}</th>
                                <th>{{ __('OS Version') }}</th>                              
                                <th>{{ __('App Version') }}</th>
                                <th width="30px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( count($tokens) > 0 )
                                @foreach( $tokens as $token )
                                    @include('admin.user.token.partials.list', ['token' => $token])
                                @endforeach
                            @else
                                @include('admin.user.token.partials.empty')
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).on('click','.delete-token', function(e){
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
                return axios.post(`/admin/tokens/${id}`, {
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