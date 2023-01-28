@extends('layouts.app')

@section('styles')

@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('site_manager.projects.zones.update', ['project_id' => $zone->project->id, 'id' => $zone->id]) }}"  >
    @csrf        
    @method('PUT')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __("Edit Zone") }} : {{ $zone->name }}</div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="row">                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="project">Project:</label>
                                <input type="text" class="form-control" value="{{ $zone->project->name_en }}" readonly="readonly">
                            </div>
                            <div class="form-group">                               
                                <label for="name">Name:</label>
                                <input type="text" name="name" class="form-control" placeholder="Zone name" value="{{ old('name', $zone->name) }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary">{{ __("Update") }}</button>
                        </div>
                        <div class="col">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary float-right">{{ __("Return Back") }}</a>
                        </div>
                    </div>
                </div>       
            </div>
        </div>
    </form>
</div>
@endsection