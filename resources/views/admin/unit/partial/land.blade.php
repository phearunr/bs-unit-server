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
</div>
<div class="row">
    <div class="col-md form-group">
        <label for="land_size_width">{{ __("Land Width") }}:</label>
        <input type="text" class="form-control" id="land_size_width" value="{{ $unit->land_size_width }}" readonly="readonly">
    </div>
    <div class="col-md form-group">
        <label for="land_size_length">{{ __("Land Length") }}:</label>
        <input type="text" class="form-control" id="land_size_length" value="{{ $unit->land_size_length }}" readonly="readonly">
    </div>
    <div class="col-md form-group">
        <label for="land_area">{{ __("Land Area") }}:</label>
        <input type="text" class="form-control" id="land_area" value="{{ $unit->land_area }}" readonly="readonly">
    </div>
</div>