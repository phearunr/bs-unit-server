 <div class="row">
    <div class="col-md form-group">
        <label for="street">{{ __("Street") }}:</label>
        <input type="text" id="street" value="{{ $unit->street }}" class="form-control" readonly="readonly">
    </div>
    <div class="col-md form-group">
        <label for="street_corner">{{ __("Street Corner") }}:</label>
        <input type="text" id="street_corner" value="{{ $unit->street }}" class="form-control" readonly="readonly">
    </div>
    <div class="col-md form-group">
        <label for="street_size">{{ __("Street Size") }}</label>
        <input type="text" id="street_size" value="{{ $unit->street_size }}" class="form-control" readonly="readonly">
    </div>
    <div class="col-md form-group">
        <label for="floor">{{ __("Floor") }}:</label>
        <input type="text" id="floor" value="{{ $unit->floor }}" class="form-control" readonly="readonly">
    </div>                        
</div>
<div class="row">
    <div class="col-md-4 form-group">
        <label for="land_size_width">{{ __("Land Width") }}:</label>
        <input type="text" class="form-control" id="land_size_width" value="{{ $unit->land_size_width }}" readonly="readonly">
    </div>
    <div class="col-md-4 form-group">
        <label for="land_size_length">{{ __("Land Length") }}:</label>
        <input type="text" class="form-control" id="land_size_length" value="{{ $unit->land_size_length }}" readonly="readonly">
    </div>
    <div class="col-md-4 form-group">
        <label for="land_area">{{ __("Land Area") }}:</label>
        <input type="text" class="form-control" id="land_area" value="{{ $unit->land_area }}" readonly="readonly">
    </div>
</div>
<div class="row">
    <div class="col-md-4 form-group">
        <label for="building_size_width">{{ __("House Width") }}:</label>
        <input type="text" class="form-control" id="building_size_width" value="{{ $unit->building_size_width }}" readonly="readonly">
    </div>                 
    <div class="col-md-4 form-group">
        <label for="building_size_length">{{ __("House Length") }}:</label>
        <input type="text" class="form-control" id="building_size_length" value="{{ $unit->building_size_length }}" readonly="readonly">
    </div>
    <div class="col-md-4 form-group">
        <label for="building_area">{{ __("House Area") }}:</label>
        <input type="text" class="form-control" id="building_area" value="{{ $unit->building_area }}" readonly="readonly">
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