@extends('layouts.app')

@section('styles')
<style type="text/css">
    .unit-container:first-child{
        margin-top: 0 !important;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center"> 
        <div class="col-lg-3 mb-3">
            <form method="GET" action="" name="user-search-from" novalidate="novalidate" autocomplete="false" class="position-sticky sticky-top-offset-1">
            <div class="card shadow-sm mb-3">         
                <div class="card-header">
                    {{ __('Filter')  }}
                    <button type="button" class="btn btn-link float-right" data-toggle="collapse" data-target="#filter-container" aria-controls="filter-container" aria-expanded="true">
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <div id="filter-container" class="collapse show">
                    <div class="card-group-item">
                        <div class="filter-content">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-12 form-group"> 
                                        <label>{{ __('Search')}}</label>                                      
                                        <input type="text" class="form-control form-control-sm" placeholder="Unit Code ..." aria-label="Name, email or phone number" aria-describedby="button-search" name="term" value="{{ Request::query('term') ?? '' }}"> 
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label>{{ __('Status')}}</label>
                                        <select name="status" class="form-control form-control-sm">
                                            <option value="">All</option>
                                            @foreach($statuses as $status)
                                            <option value="{{ $status }}" {{ ( Request::query('status') == $status ) ? 'selected' : '' }}>{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label>{{ __('Unit Type')}}</label>
                                        <select name="unit_type_id" class="form-control form-control-sm">
                                            <option value="">All</option>
                                            @foreach($unit_types as $unit_type)
                                            <option value="{{ $unit_type->id }}" {{ ( Request::query('unit_type_id') == $unit_type->id ) ? 'selected' : '' }}>{{ $unit_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="zone_id">Zone</label>
                                        <select name="zone_id" id="zone_id" class="form-control form-control-sm">
                                            <option value="">All</option>
                                            @foreach($zones as $zone)
                                            <option value="{{ $zone->id }}" {{ ( Request::query('zone_id') == $zone->id ) ? 'selected' : '' }}>{{ $zone->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12"> 
                                        <button type="submit" class="btn btn-primary btn-sm">{{ __('Show') }}</button>
                                        <a href="{{ url()->current() }}" class="btn btn-danger btn-sm float-right">{{ __('Clear') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <div class="col-lg-9">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
            @if( $units->count() == 0 )            
            <div class="card">
                <div class="card-body">
                    <h5 class="text-center mb-0">No unit found</h5>
                </div>
            </div>
            @endif
            @foreach($units as $unit)
            <div class="d-flex border unit-container w-100 bg-white my-2 shadow-sm">
                <div class="align-self-center w-100 px-3 py-2">
                    <h5 class="mb-0 font-weight-bold"><a href="{{ route('admin.units.show', ['id'=>$unit->id]) }}">{{ $unit->code }}</a></h5>
                    <span class="text-muted d-block">{{ $unit->unitType->name }} | {{ $unit->unitType->project->name_en }} | {{ ($unit->zone) ? $unit->zone->name : 'Unassigned Zone' }}</span>
                </div>

                <div class="align-self-center  px-3" style="width:300px;">                    
                    <span class="{{ $unit->action->getActionCss() }}">{{ $unit->action->action }}</span>
                    <span class="{{ $unit->action->getStatusActionCss() }}">{{ $unit->action->status_action }}</span>
                </div>

                <div class="align-self-center p-3" style="width:250px;">
                    <span class="d-block text-right">Price</span>
                    <h5 class="m-0 font-weight-bold text-nowrap text-right">
                        $ {{ number_format($unit->price) }}
                    </h5> 
                </div>    
                <div class="justify-content-end align-self-center px-3">
                    <div class="btn-group">
                        <a href="#" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="true" class="text-primary">
                            <i class="fas fa-lg fa-ellipsis-v"></i>
                        </a> 
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="javascript:void(0)" data-unit-id="{{ $unit->id }}" data-zone-id="{{ $unit->zone_id }}" data-unit-code="{{ $unit->code }}" class="dropdown-item addUnitToZoneButton">Add to Zone</a>
                            @if( Auth::user()->can('create-handover-request') )
                            @if($unit->action->action == "CONTRACT" )
                            <a href="{{route('admin.unit.unit_handovers.create',['id'=>$unit->id])}}" data-unit-id="{{ $unit->id }}"  class="dropdown-item ">Create Unit Handover</a>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            {{ $units->onEachSide(1)->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="ZoneModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Unit to Zone</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="unit_code">Unit Code:</label>
                    <input type="text" class="form-control" name="unit_code" readonly="readonly" />
                </div>
                <div class="form-group">
                    <input type="hidden" name="selected_unit_id" />    
                    <input type="hidden" name="current_zone_id">                
                    <label for="zone_dropdown">Zone:</label>
                    <select class="form-control" name="zone_dropdown" id="zone_dropdown">
                        @foreach($zones as $zone)
                        <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="buttom" class="btn btn-primary" id="confirmAddToZone">Add to Zone</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript"> 
    function addUnitToZone(unitId, zoneId) {
        axios.post(`/admin/units/${unitId}/addToZone`, {
            zone_id : zoneId,
            _method : 'POST'
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

    $(document).ready(function () {
        $('.addUnitToZoneButton').on('click', function(event) {         
            $('input[name="selected_unit_id"]').val($(event.target).data('unitId'));
            $('input[name="unit_code"]').val($(event.target).data('unitCode'));
            $('input[name="current_zone_id"]').val($(event.target).data('zoneId'));
            $('#ZoneModal').modal('show');
        })

        $('#confirmAddToZone').on('click', function() {
            var unitId = $('input[name="selected_unit_id"]').val();
            var currentZoneId = $('input[name="current_zone_id"]').val();
            var zoneId = $('select[name="zone_dropdown"]').val();

            if ( $('input[name="selected_unit_id"]').val() == '' ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Look like we can find unit to want to add into the zone.',
                }).then(function (){
                    $('#ZoneModal').modal('hide');
                });
                return;
            } 

            if (currentZoneId != '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ooh oh...',
                    text: "Look like the unit you have selected already got zone. Are you sure want to change to this zone?",
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!'
                })
                .then( function (result){                    
                    if ( result.isConfirmed ) {
                        addUnitToZone(unitId, zoneId);
                    } else {
                        $('#ZoneModal').modal('hide');
                    }
                });
            } else {
                addUnitToZone(unitId, zoneId);
            }
        })
    })
</script>
@endpush
