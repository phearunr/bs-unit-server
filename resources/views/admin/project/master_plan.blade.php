@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<project-master-plan 
	file-path="{{ $project->master_plan_url }}" 	
	v-bind:project-id="{{ $project->id }}"
	v-bind:unit-construction-editable="{{ json_encode(Auth::user()->can(['create-unit-construction', 'update-unit-construction'])) }}">
		
</project-master-plan>
@endsection

@push("scripts")
<script type="text/javascript">  
$('main').removeClass('py-4');
</script>
@endpush
