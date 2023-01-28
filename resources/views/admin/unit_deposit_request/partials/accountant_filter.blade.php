<div class="form-row">
    <div class="input-group input-group-sm col-lg-4">
        <div class="input-group-prepend">
            <label class="input-group-text" for="status">Date:</label>
        </div>
        <input type="text" class="form-control datepicker" name="from" 
                   value="{{ Request::query('from') ? Request::query('from') : '' }}"
            >
        <div class="input-group-prepend">
            <label class="input-group-text" for="to">to</label>
        </div>                               
        <input type="text" class="form-control datepicker" name="to" 
            value="{{ Request::query('to') ? Request::query('to') : '' }}"
        >
    </div>
   
    <div class="input-group input-group-sm col-md-3">
        <div class="input-group-prepend">
            <label class="input-group-text" for="status">{{ __("Payment Status") }}</label>
        </div>
        <select class="form-control" name="payment_status" id="status">                                  
            @foreach($payment_statuses AS $value)
            <option value="{{ $value }}" {{ Request::query('payment_status') == $value ? 'selected' : '' }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-sm btn-primary" type="submit" id="fileter-button">Show</button>
        <a href="{{ route('admin.unit_deposit_requests.index') }}" class="btn btn-secondary btn-sm ml-md-2">Clear Filter</a>
</div>