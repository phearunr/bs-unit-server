@extends('layouts.app')

@section('styles')
<style type="text/css">   
</style>
@endsection

@section('content')
<div class="container"> 
    @if (session('status'))
    <div class="row">
        <div class="col">
            <div class="alert alert-success alert-dismissible fade show"  role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-lg-4 mb-3">
            <div class="card bg-white">
                <div class="card-body bg-secondary py-5">
                    <h3 class="text-center font-weight-bold"><span class="text-white">{{ $zone->name }}</span></h3>
                    <h6 class="text-center text-white">{{ $zone->project->name_en }}</h6>
                    @can('update-zone')
                        <a href="{{ route('site_manager.projects.zones.edit', ['project_id' => $zone->project->id, 'id' => $zone->id]) }}" class="position-absolute btn btn-primary btn-sm" style="top: 1rem; right: 1rem;"><i class="far fa-edit"></i></a>
                    @endcan
                    <div class="d-flex justify-content-center">
                        <button class=" btn btn-primary btn-sm" id="addUnitToZoneButton">Add Unit to Zone</button>    
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <ul class="yk-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ URL::current() }}">Units</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('site_manager.zones.site_engineers.index', [ 'zone_id' => $zone->id])}}">Site Engineers</a>
                </li>
            </ul>

            <div class="row">
                <div class="col">
                @if( $units->count() == 0 )            
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-center mb-0">No unit found</h5>
                        </div>
                    </div>
                @else
                    <form>
                    <div class="input-group mb-3">
                        <input type="text" name="term" class="form-control" placeholder="Unit's Code" aria-label="Unit's Code" aria-describedby="button-find" value="{{ Request::query('term') }}">
                        <div class="input-group-append">
                            @if(Request::query('term'))
                            <a class="btn btn-outline-secondary" href="{{  URL::current() }}">Clear</a>  
                            @endif
                            <button class="btn btn-secondary" type="submit" id="button-find">Find</button>
                        </div>
                    </div>
                    </form>
                    @foreach($units as $unit)
                    <div class="d-flex border unit-container w-100 bg-white my-2 shadow-sm">
                        <div class="align-self-center w-100 px-3 py-2">
                            <h5 class="mb-0 font-weight-bold">
                                {{ $unit->code }}
                            </h5>
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
                                    @can('update-unit-construction')
                                    <a href="{{ route('site_manager.projects.units.show', ['project_id' => $zone->project_id, 'unit_id' => $unit->id]) }}" class="dropdown-item">
                                        {{ __('Edit') }} {{ __("Construction Progress") }}
                                    </a>
                                    @endcan
                                    <a href="#" data-zone-id="{{ $unit->zone_id }}" data-unit-id="{{ $unit->id }}" class="dropdown-item delete_button">
                                        {{ __('Remove from Zone') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach                
                    {{ $units->onEachSide(1)->appends(request()->except(['page','_token'])) }}
                @endif
                </div>
            </div>
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
                    <input type="text" class="form-control" id="unit_code" name="unit_code"/>
                    <input type="hidden" name="zone_id" value="{{ $zone->id }}">
                    <span class="text-danger d-none" id="errorMsg"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="buttom" class="btn btn-primary" id="confirmAddUnitToZone">Add Unit</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript"> 
    function addUnitToZone(unitCode, zoneId) {
        axios.post(`/site_manager/zones/${zoneId}/units/associateUnitByCode`, {
            unit_code : unitCode,
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
            }
        })
        .catch(function (error) {
            if (error.response.status == 404) {
                Swal.fire(
                    'Not Found',
                    `Unit: [${unitCode}] can not be found in the system.`,
                    'error'
                );    
            } else {
                Swal.fire(
                    'Error',
                    error.response.data.error.message,
                    'error'
                );    
            }     
        });
    }

    function removeUnitFromZone(zoneId, unitId)
    {
        axios.delete(`/site_manager/zones/${zoneId}/units/${unitId}/removeZone`)
        .then( function (response) {
            if ( response.status >= 200 && response.status < 300 ) {
                Swal.fire(
                    'Successful',
                    response.data.message,
                    'success'
                ).then( function () {
                    location.reload();
                });
            }
        })
        .catch(function (error) {
            if (error.response.status == 404) {
                Swal.fire(
                    'Not Found',
                    `Unit can not be found in the system.`,
                    'error'
                );    
            } else {
                Swal.fire(
                    'Error',
                    error.response.data.error.message,
                    'error'
                );    
            }     
        });
    }

    $(document).ready(function () {
        $('#addUnitToZoneButton').on('click', function(event) {
            $('input[name="unit_code"]').val('');
            $('#errorMsg').text("");
            $('#errorMsg').addClass('d-none');
            $('#ZoneModal').modal('show');
        });

        $('#confirmAddUnitToZone').on('click', function() {
            var unitCode = $('input[name="unit_code"]').val();
            var zoneId = $('input[name="zone_id"]').val();                    
          

            if ( unitCode == '' ) {
                $('#errorMsg').text("Unit Code can not be empty.");
                $('#errorMsg').removeClass('d-none');
                return;
            } 

            addUnitToZone(unitCode, zoneId);
        });

        $('.delete_button').on('click', function(event) {
            var ele = event.target;
            console.log(`Zone ID: ${ele.dataset.zoneId}, Unit ID: ${ele.dataset.unitId}`);

            Swal.fire({                
                text: "Are you sure want to remove the unit form this zone?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(`Zone ID: ${ele.dataset.zoneId}, Unit ID: ${ele.dataset.unitId}`);
                    removeUnitFromZone(ele.dataset.zoneId, ele.dataset.unitId);
                }
            })
        });
    })
</script>
@endpush