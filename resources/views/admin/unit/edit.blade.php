@extends('layouts.app')

@section('styles')
<style type="text/css">
    
</style>
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.units.update', $unit->id) }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data">
    @csrf     
    {{ method_field("PUT") }}   
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __("Edit") }} {{__("Unit")}} : {{ $unit->code }} </div>
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
                        
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label for="unit_type_id">{{ __('Unit Type') }}:</label>
                                <select class="form-control select2{{ $errors->has('unit_type_id') ? ' is-invalid' : '' }}" name="unit_type_id">
                                    @foreach ( $projects as $project )
                                        <optgroup label="{{ $project->name_en }}">
                                        @foreach( $project->unitTypes as $unit_type )
                                            <option value="{{ $unit_type->id }}" 
                                                    {{ $unit_type->id == $unit->unit_type_id ? "selected" : "" }} >
                                                    {{ $unit_type->name }} ({{ $project->name_en }})
                                            </option>
                                        @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @if($errors->has('unit_type_id'))
                                <div class="invalid-feedback">{{ $errors->first('unit_type_id') }}</div> 
                                @endif                                           
                            </div>                           
                            <div class="col-lg form-group">
                                <label for="code">{{ __('Unit Code') }}: <span class="text-danger">*</span></label>
                                <input type="text" name="code" id="code" class="form-control" value="{{ $unit->code }}">
                            </div>  
                            <div class="col-lg form-group">
                                <label for="price">{{ __('Price') }}: <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="price" class="form-control" value="{{ $unit->price }}">
                            </div>                          
                        </div>
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="street">{{ __('Street') }}:</label>
                                <input type="text" name="street" id="street" class="form-control" value="{{ $unit->street }}">
                            </div>
                            <div class="col-lg form-group">
                                <label for="street_corner">{{ __('Street Corner') }}:</label>
                                <input type="text" name="street_corner" id="street_corner" class="form-control" value="{{ $unit->street_corner }}">
                            </div>
                            <div class="col-lg form-group">
                                <label for="street_size">{{ __('Street Size') }}:</label>
                                <input type="text" name="street_size" id="street_size" class="form-control" value="{{ $unit->street_size }}">
                            </div>
                            <div class="col-lg form-group">
                                <label for="floor">{{ __('Floor') }}:</label>
                                <input type="text" name="floor" id="floor" class="form-control" value="{{ $unit->floor }}">
                            </div>
                        </div>
                        <h5>{{ __('Measurements') }}:</h5>
                        <hr class="mt-0">
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="land_size_width">{{ __('Land Width') }}:</label>
                                <input type="number" name="land_size_width" id="land_size_width" class="form-control" value="{{ $unit->land_size_width }}">
                            </div>
                            <div class="col-lg form-group">
                                <label for="land_size_length">{{ __('Land Length') }}:</label>   
                                <input type="number" name="land_size_length" id="land_size_length" class="form-control" value="{{ $unit->land_size_length }}">
                            </div>
                            <div class="col-lg form-group">
                                <label for="land_area">{{ __('Land Area') }}:</label>
                                <input type="number" name="land_area" id="land_area" class="form-control" value="{{ $unit->getOriginal('land_area') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="building_size_width">{{ __('House Width') }}:</label>   
                                <input type="number" name="building_size_width" id="building_size_width" class="form-control" value="{{ $unit->building_size_width }}">
                            </div>                        
                            <div class="col-lg form-group">
                                <label for="building_size_length">{{ __('House Length') }}:</label>
                                <input type="number" name="building_size_length" id="building_size_length" class="form-control" value="{{ $unit->building_size_length }}">
                            </div>
                            <div class="col-lg form-group">
                                <label for="building_area">{{ __('House Area') }}:</label>   
                                <input type="number" name="building_area" id="building_area" class="form-control" value="{{ $unit->getOriginal('building_area') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gross_area" class="col-lg-8 col-form-label text-lg-right">If unit is condo, please state the gross area:</label>
                            <div class="col-lg-4">
                                <input type="email" class="form-control" name="gross_area" id="gross_area" value="{{ old('gross_area') ?? $unit->gross_area }}" placeholder="Gross Area">
                            </div>
                        </div>

                        <h5>{{ __('Facilities') }}:</h5>
                        <hr class="mt-0">
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="living_room">{{ __('Living Room') }}:</label>
                                <input type="number" min="0" name="living_room" id="total_area_size" class="form-control" value="{{ $unit->living_room }}">
                            </div>
                            <div class="col-lg form-group">
                                <label for="kitchen">{{ __('Kitchen') }}:</label>
                                <input type="number" min="0" name="kitchen" id="kitchen" class="form-control" value="{{ $unit->kitchen }}">
                            </div>
                            <div class="col-lg form-group">
                                <label for="bedroom">{{ __('Bedroom') }}:</label>
                                <input type="number" min="0" name="bedroom" id="bedroom" class="form-control" value="{{ $unit->bedroom }}">
                            </div>
                            <div class="col-lg form-group">
                                <label for="bathroom">{{ __('Bathroom') }}:</label>
                                <input type="number" min="0" name="bathroom" id="bathroom" class="form-control" value="{{ $unit->bathroom }}">
                            </div>
                            <div class="col-lg form-group">
                                <label for="swimming_pool">{{ __('Swimming Pool') }}:</label>
                                <input type="number" min="0" name="swimming_pool" id="swimming_pool" class="form-control" value="{{ $unit->swimming_pool }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{__("Update")}} {{ __("Unit") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.units.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Unit List") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row mb-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                {{ __("Lastest Action") }}
                            </div>
                            <div class="card-body">
                                @switch($unit->action->actionable_type)
                                    @case("App\\UnitHoldRequest")
                                    @case("App\\UnitDepositRequest")
                                    @case("App\\UnitContractRequest")
                                        <div class="row">
                                            <div class="col-md-auto pr-0">
                                                <img src="{{ $unit->action->actionable->createdBy->avatar_url  }}" class="rounded user-avatar-50 float-left">
                                            </div>
                                            <div class="col-md">
                                                <span class="font-weight-bold d-block">{{ $unit->action->actionable->createdBy->name }}</span>
                                                <span class="font-weight-bold d-block">{{ $unit->action->actionable->createdBy->phone_number }}</span>
                                                {!! $unit->action->status_html !!}                                                
                                            </div>

                                        </div>
                                    @default

                                @endswitch                               
                            </div>
                        </div>                        
                    </div>
                </div>
                <unit-action-history unit-id="{{ $unit->id }}"></unit-action-history>
                <unit-price-history unit-id="{{ $unit->id }}"></unit-price-history>
            </div>
        </div>
    </form>
</div>
@endsection