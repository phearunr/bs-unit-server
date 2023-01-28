@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <construction-masterplan file-path="{{ $project->master_plan_url }}" v-bind:project-id="{{ $project->id }}"></construction-masterplan>
@endsection

@push("scripts")
<script type="text/javascript">  
$('main').removeClass('py-4');
</script>
@endpush
