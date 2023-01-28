@extends('layouts.app')

@section('styles')
<style type="text/css">
    .table th[scope="col"] {
        border-top: 0px;
    }
    .tab-content {
        border-left: 1px solid #dee2e6;
        border-right: 1px solid #dee2e6;
        border-bottom: 1px solid #dee2e6;
    }
    .nav-tabs .nav-link.active {
        background: #FFF;
    }
</style>
@endsection

@section('content')
<div class="container"> 
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card mb-3">
                <img src="{{ $unit->unitType->feature_image_url }}" alt="Card image cap" class="card-img-top"> 
                <div class="card-body pb-0 position-relative">
                    <h5 class="mb-0">{{ $unit->code }}</h5>
                    <h5 class="mb-0">
                        <strong class="text-primary">$ {{ number_format($unit->price, 2) }}</strong>
                        <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="View Price History"><i class="fas fa-history"></i></button>
                    </h5> 
                    <span class="{{ $unit->action->getActionCss() }}">{{ $unit->action->action }}</span>
                    <span class="{{ $unit->action->getStatusActionCss() }}">{{ $unit->action->status_action }}</span>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <small class="text-muted d-block">Unit Type</small>
                        <span class="d-block font-weight-bold">{{ $unit->unitType->name }}</span>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">Zone</small>
                        <span class="d-block font-weight-bold">{{ ($unit->zone) ? $unit->zone->name : 'Unassigned Zone' }}</span>
                    </li>                    
                    <li class="list-group-item">
                        <small class="text-muted d-block">Project</small>
                        <span class="d-block font-weight-bold">{{ $unit->unitType->project->name_en }}</span>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">Company</small>
                        <span class="d-block font-weight-bold">{{ $unit->unitType->project->company->name_en }}</span>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">Measurement</small> 
                        <span class="d-block font-weight-bold">Land Size: {{ ( ($unit->land_size_width AND $unit->land_size_length)  ? $unit->land_size_width.'m x '.$unit->land_size_length.'m' : $unit->land_area. ' Sqm' )}}</span>

                        <span class="d-block font-weight-bold">Building Size: {{ ( ($unit->building_size_width AND $unit->building_size_length) ? $unit->building_size_width.'m x '.$unit->building_size_length.'m' : $unit->building_area. ' Sqm' )}}</span>
                    </li>  
                    <li class="list-group-item"><small class="text-muted d-block">Facilities</small> 
                        <table class="table table-borderless table-sm mb-0">
                            <tbody>
                                <tr class="font-weight-bold">
                                    <td>Bedroom:</td>
                                    <td>{{ ( $unit->bedroom ? $unit->bedroom : 'n/a' ) }}</td>
                                </tr>
                                <tr class="font-weight-bold">
                                    <td>Bathroom:</td>
                                    <td>{{ ( $unit->bathroom ? $unit->bathroom : 'n/a' ) }}</td>
                                </tr>
                                <tr class="font-weight-bold">
                                    <td>Living Room:</td>
                                    <td>{{ ( $unit->living_room ? $unit->living_room : 'n/a' ) }}</td>
                                </tr>
                                <tr class="font-weight-bold">
                                    <td>Kitchen:</td>
                                    <td>{{ ( $unit->kitchen ? $unit->kitchen : 'n/a' ) }}</td>
                                </tr>
                               
                                <tr class="font-weight-bold">
                                    <td>Swimming Pool:</td>
                                    <td>{{ ( $unit->swimming_pool ? $unit->swimming_pool : 'n/a' ) }}</td>
                                </tr>
                            </tbody>
                        </table>             
                    </li>  
                </ul>
                <div class="card-footer">
                    <small class="text-muted d-block">
                        <i class="far fa-clock"></i> Last updated: {{ $unit->updated_at->diffForHumans() }}
                    </small>
                    <small class="text-muted d-block">
                        <i class="fas fa-user-alt"></i> Updated by: {{ $unit->createdBy->name }} 
                    </small>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="transaction-tab" data-toggle="tab" href="#transaction" role="tab" aria-controls="transaction" aria-selected="true">Transaction</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="construction-progress-tab" data-toggle="tab" href="#construction-progress" role="tab" aria-controls="construction-progress" aria-selected="false">Construction Progress</a>
                </li>
              
            </ul>
            <div class="tab-content bg-white" id="myTabContent">
                <div class="tab-pane fade show active" id="transaction" role="tabpanel" aria-labelledby="transaction-tab">
                    <unit-transaction-table unit-id="{{ $unit->id }}"></unit-transaction-table>
                </div>
                <div class="tab-pane fade" id="construction-progress" role="tabpanel" aria-labelledby="construction-progress-tab">
                    <div class="p-4">
                        <unit-construction-procedure unit-id="{{ $unit->id }}" :editable="{{ (Auth::user()->can('update-unit-construction')) ? 'true' : 'false' }}"></unit-construction-procedure>                        
                    </div>
                    <div class="px-4 pb-2">
                        <h4>Comments:</h4>
                        <unit-comment-list unit-id="{{ $unit->id }}" :allow-comment="true"></unit-comment-list>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush