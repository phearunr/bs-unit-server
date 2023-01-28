@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<availability-masterplan file-path="{{ $project->master_plan_url }}" v-bind:project-id="{{ $project->id }}"></availability-masterplan>
@endsection

@push("scripts")
<script type="text/javascript">  
$('main').removeClass('py-4');
</script>
@endpush
