@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
	<!-- Main content -->
	<section class="content">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-12 mb-3"><user-summary-card user-id="{{ $user->id }}"></user-summary-card></div>
				</div>
				<div class="row">
					<div class="col-md-12"><user-activities-component user-id="{{ $user->id }}"></user-activities-component></div>
				</div>							
			</div>
			<div class="col-md-4">				
			</div>
		</div>
	</section>
</div>
 
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush