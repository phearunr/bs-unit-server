@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.unit_handovers.import') }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data">
    @csrf
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __("Unit Handover")}} : {{ __("Import") }}</div>
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
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="project_id">{{ __('Please select project') }}</label>
                                <select class="form-control" id="project_id" name="project_id">
                                    @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="data_updated_on">{{ __("Data Updated on") }}:</label>
                                <input type="text" class="form-control datepicker" name="data_updated_on" id="data_updated_on" 
                                    value="{{ old('data_updated_on') ? old('data_updated_on') : date(config('app.php_date_format')) }}">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="unit_handover_list">{{ __('Select CSV file format') }}</label>
                                <div class="custom-file">
                                    <input type="file" name="unit_handover_list" id="unit_handover_list" />
                                    <label class="custom-file-label" for="unit_handover_list">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{ __("Import")}} {{ __("Unit") }}</button>
                                <a href="{{ route('admin.unit_handovers.import_template') }}" class="btn btn-success">Template File</a>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Unit") }} {{ __("List") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection