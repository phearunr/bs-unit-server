@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.units.import') }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data">
    @csrf

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __("Unit")}} : {{ __("Import") }}</div>
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
                            <div class="col input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="unit_import">Select CSV file Format:</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="unit_import" class="unit_import" id="inputGroupFile01" />
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{ __("Import")}} {{ __("Unit") }}</button>
                                <a href="{{ route('admin.units.import_template') }}" class="btn btn-success">Template File</a>
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
