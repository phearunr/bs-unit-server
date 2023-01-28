@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.units.bulk_status_modify') }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data">
    @csrf
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __("Unit")}} : {{ __("Modify Status") }}</div>
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
                                <label for="action">Action</label>
                                <select class="form-control" id="action" name="action">
                                    <option value="CONTRACT">CONTRACT</option>                          
                                </select>
                            </div>
                             <div class="form-group col-md-12">
                                <label for="action_status">Action Status</label>
                                <select class="form-control" id="action_status" name="action_status">
                                    <option value="OPEN">OPEN</option>                          
                                </select>
                            </div>                           
                            <div class="form-group col-md-12">
                                <label for="unit_list">{{ __('Select CSV file format') }}</label>
                                <div class="custom-file">
                                    <input type="file" name="unit_list" id="unit_list" />
                                    <label class="custom-file-label" for="unit_list">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{ __("Import")}} {{ __("Unit") }}</button>
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