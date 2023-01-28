<div class="row">
    <div class="col-md form-group">
        <label for="floor">{{ __("Floor") }}</label>
        <input type="text" id="floor" value="{{ $unit->floor }}" class="form-control" readonly="readonly">
    </div>
    <div class="col-md form-group">
        <label for="building_area">{{ __("Net Area") }}</label>
        <input type="text" id="building_area" value="{{ $unit->net_area }}" class="form-control" readonly="readonly">
    </div>
    <div class="col-md form-group">
        <label for="building_area">{{ __("Gross Area") }}</label>
        <input type="text" id="building_area" value="{{ $unit->gross_area }}" class="form-control" readonly="readonly">
    </div>
    <div class="col-md form-group">
        <label for="street_size">{!! __("Management Fee Per Sqm") !!}</label>
        <input type="text" id="street_size" value="{{ $unit->unitType->management_fee_per_square }}" class="form-control" readonly="readonly">
    </div>                   
</div>
<div class="row">
    <div class="col-md-3 form-group">
        <label for="living_room">{{ __("Living Room") }}:</label>
        <input type="text" class="form-control" id="living_room" value="{{ $unit->living_room }}" readonly="readonly">
    </div>
    <div class="col-md-3 form-group">
        <label for="kitchen">{{ __("Kitchen") }}:</label>
        <input type="text" class="form-control" id="kitchen" value="{{ $unit->kitchen }}" readonly="readonly">
    </div>
    <div class="col-md-3 form-group">
        <label for="bedroom">{{ __("Bedroom") }}:</label>
        <input type="text" class="form-control" id="bedroom" value="{{ $unit->bedroom }}" readonly="readonly">
    </div>
    <div class="col-md-3 form-group">
        <label for="bathroom">{{ __("Bathroom") }}:</label>
        <input type="text" class="form-control" id="bathroom" value="{{ $unit->bathroom }}" readonly="readonly">
    </div>       
</div>