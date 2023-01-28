@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <h5>{{ $zone->name }} <small class="text-muted d-block">{{ $zone->project->name_en }}</small></h5>
            <div class="card mb-4">
                <div class="card-body pb-0 bg-secondary">
                    <div class="form-group">
                        <label for="search" class="text-white">Enter Unit Code for filtering:</label>
                        <input type="text" class="form-control" name="unit-code-filter" id="search" placeholder="Unit Code">
                    </div>
                </div>
                <div class="card-body">
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            
        </div>
    </div>
</div>
@endsection
