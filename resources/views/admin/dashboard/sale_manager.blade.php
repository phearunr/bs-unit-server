@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />

@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
		<div class="col-lg-8">
			<div class="card ">				
				<div class="card-body">
					<unit-activity-statistic chart-id='unit-activity-statistic' height="300px"></unit-activity-statistic>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card">
				<div class="card-body">		
					<unit-availability-statistic chart-id='unit-availability-statistic' height="300px"></unit-availability-statistic>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">	
</script>
@endpush