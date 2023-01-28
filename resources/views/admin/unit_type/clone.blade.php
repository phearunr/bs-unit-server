@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.unit_types.clone', [ 'id' => $unit_type->id ]) }}" novalidate="novalidate" autocomplete="false">
    @csrf                
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __("Clone") }} {{__("Payment Option")}} : <strong>{{ $unit_type->name }}</strong></div>
                    <div class="card-body">
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
                        <input type="hidden" name="id" value="{{ $unit_type->id }}" readonly="readonly">
                        <p class="mb-0">Clone this unit type <strong>({{ $unit_type->name }})</strong>'s payment options to :</p>
                        <div class="form-group my-2">                           
                            <select class="form-control select2" name="unit_type_id" id="unit_type_id">
                                @foreach ( $projects as $project )
                                    <optgroup label="{{ $project->name }}">
                                    @foreach( $project->unitTypes as $unit_type_obj )
                                        @if( $unit_type->id !=  $unit_type_obj->id )
                                        <option value="{{ $unit_type_obj->id }}">
                                                {{ $unit_type_obj->name }}
                                        </option>
                                        @endif
                                    @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <p class="text-warning mb-0"><small>The target unit type's payment option will be permanently deleted from system.</small></p> 
                        <p class="text-warning mb-0"><small>Note: the target unit type's payment option can not be related with other record.</small></p> 
                    </div>
                    
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{ __("Clone it") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.unit_types.index') }}" class="btn btn-secondary float-right">{{ __("No, Back to Unit Type list.") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

$(document).ready(function (){
    $('.select2').select2({ theme:"bootstrap4" });
});

</script>
@endpush
