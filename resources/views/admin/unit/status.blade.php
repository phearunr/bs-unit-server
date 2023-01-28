@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.units.status.change', [ 'id' => $unit->id ]) }}" novalidate="novalidate" autocomplete="false">
    @csrf           
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __("Change") }} {{__("Status")}} : <strong>{{ $unit->code }}</strong></div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <input type="hidden" name="id" value="{{ $unit->id }}" readonly="readonly">
                        <div class="form-group">
                            <p class="mb-0 d-inline">Change status of : <strong>{{ $unit->code.' - '.$unit->unitType->name." | ".$unit->unitType->project->name_en  }} </strong> to</p>
                            <select name="status" class="inline-select">
                                <!-- @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ $unit->status == $status ? "selected" : "" }}>{{ ucfirst($status) }}</option>
                                @endforeach -->
                                <option value="AVAILABLE">AVAILABLE</option>
                                <option value="UNAVAILABLE">UNAVAILABLE</option>
                            </select>
                        </div>
                        <div class="form-group mb-0 bg-secondary">
                            <label for="description" class="text-white mb-0 pl-1">{{ __('Note') }}</label>
                            <textarea name="description" id="description" placeholder="..." class="form-control form-control-flat"></textarea>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-success">{{ __("Yes, Change it.") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.units.index') }}" class="btn btn-secondary float-right">{{ __("No, Back to Unit list.") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
