@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<project-master-plan-sale 
	file-path="{{ $project->master_plan_url }}" 	
	v-bind:project-id="{{ $project->id }}">
</project-master-plan-sale>
@endsection

@push("scripts")
<script type="text/javascript">  
$('main').removeClass('py-4');
</script>
@endpush
