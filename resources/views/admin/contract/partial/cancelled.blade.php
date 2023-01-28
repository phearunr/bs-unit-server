<div class="col-md-12 mb-4">
	<div class="card">
		<div class="card-header text-center">{!! $contract->getStatusHtml() !!}</div>
		<div class="card-body">
			<div class="row">
				<div class="col-lg-6 form-group">
			        <label for="cancelled-by">{{ __('Cancelled By') }}:</label>
			        <input type="text" id="cancelled-by" value="{{ $contract->actionedBy->name }}" class="form-control" readonly="readonly">
			    </div>
			    <div class="col-lg-6 form-group">
			        <label for="customer1_name">{{ __('Cancelled At') }}:</label>
			        <input type="text"  id="customer1_name" value="{{ $contract->actioned_at->toSystemDateTimeString() }}" class="form-control" readonly="readonly">
			    </div>
		    </div>
		    <div class="row">
		    	<div class="col-lg-12 form-group">
		    		<label for="reason">{{ __('Reason') }}:</label>
		    		<textarea id="reason" class="form-control" rows="2" readonly="readonly">{{ $contract->reason }}</textarea>
		    	</div>
		    </div>
		</div>
	</div>
</div>