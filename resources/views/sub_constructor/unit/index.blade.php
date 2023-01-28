@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container ">
    <div class="row mb-3 justify-content-center">
        <div class="col-md-12 col-lg-8">
            <div class="d-flex bg-white p-2 border shadow-sm">
                <div class="user-avatar-container">
                    <img src="{{ $sub_constructor->avatar_url }}" class="user-avatar-75 rounded-circle">
                </div>
                <div class="flex-grow pl-3">
                    <h5 class="mb-0 font-weight-bold"><a href="{{ route('sub_constructors.edit', ['id' => $sub_constructor->id]) }}">{{ $sub_constructor->name }}</a></h5>
                    <div class="d-block">
                        <span class="text-muted">Join Date:</span> <span>{{ $sub_constructor->join_date->toSystemDateString() }}</span>
                    </div>
                    <div class="d-block">
                        @if( $contact = $sub_constructor->contacts->first() )
                            <span class="text-muted">Contacts:</span> <span>{{ $contact->value }}</span>
                        @endif
                        @if( $sub_constructor->contacts_count >= 2 ) 
                            <a href="{{ route('sub_constructors.edit', ['id' => $sub_constructor->id])}}">
                                <small>{{ $sub_constructor->contacts_count - 1 }} more</small>
                            </a>
                        @endif
                    </div>
                    <div class="d-block">
                        @if( $skill = $sub_constructor->skills->first() )                                      
                            <span class="text-muted">Skills:</span> {{ $skill->name_km }} ({{$skill->name}})
                        @endif

                        @if( $sub_constructor->skills_count >= 2 ) 
                        <a href="{{ route('sub_constructors.edit', ['id' => $sub_constructor->id]) }}">
                            <small>{{ $sub_constructor->skills_count - 1 }} more</small>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-8">
            <h5 class="border-bottom">Managed Units: ( {{ number_format($sub_constructor->units_count, 0) }} )</h5>
        </div>
        <div class="col-md-12 col-lg-8">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form method="POST" autocomplete="off">
            @csrf
            <div class="input-group">
                <input type="text" name="unit_code" value="{{ old('unit_code') }}" class="form-control" placeholder="Unit Code" aria-describedby="btnAddUnit">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" id="btnAddUnit">Add Unit</button>
                </div>
            </div>
            </form>
        </div>
        <div class="col-md-12 col-lg-8">
            @foreach($units as $unit)
            <div class="d-flex position-relative border unit-container w-100 bg-white my-2 shadow-sm">
                <div class="align-self-center w-100 flex-grow px-3 py-2">
                    <h5 class="mb-0 font-weight-bold">{{ $unit->code }}</h5>    
                    <span class="text-muted d-block">{{ $unit->unitType->name }} | {{ $unit->unitType->project->name_en }} | {{ ($unit->zone) ? $unit->zone->name : 'Unassigned Zone' }}</span>
                </div>
                <div class="align-self-center px-3">                    
                    <span class="{{ $unit->action->getActionCss() }}">{{ $unit->action->action }} </span><br>
                    <span class="{{ $unit->action->getStatusActionCss() }}">{{ $unit->action->status_action }}</span>
                </div>
                <div class="align-self-center btn-group px-2">
                    <a href="#" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false" class="text-primary">
                        <i class="fas fa-lg fa-ellipsis-v"></i>
                    </a> 
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="javascript::void(0)" data-sub-constructor-id="{{ $sub_constructor->id }}" data-unit-id="{{ $unit->id }}" class="dropdown-item delete_button">Remove</a>
                    </div>
                </div>
            </div>
            @endforeach
            {{ $units->onEachSide(1)->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
function removeUnitFromSubConstructor(subConstructorId, unitId)
{
    axios.delete(`/sub_constructors/${subConstructorId}/units/${unitId}`)
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
    $('.delete_button').on('click', function(event) {
        var ele = event.target;
        Swal.fire({                
            text: "Are you sure want to remove the unit form this Sub Constructor?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                removeUnitFromSubConstructor(ele.dataset.subConstructorId, ele.dataset.unitId);
            }
        })
    });
})
</script>
@endpush