@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.app_versions.store') }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data">
    @csrf        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{__("Mobile App Version")}} : {{ __("Create New") }}</div>
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
                            <div class="col-lg form-group">
                                <label for="platform">{{ __("Platform") }}:</label>
                                <select name="platform" class="form-control">
                                   @foreach($platforms AS $platform)
                                   <option value="{{ $platform }}" {{ old('platform') == $platform ? "selected" : "" }} >{{ $platform }}</option>
                                   @endforeach
                                </select>
                            </div>
                            <div class="col-lg form-group">
                                <label for="">{{ __("Build") }}:</label>
                                <input type="number" class="form-control" name="build" value="{{ old('build') }}"/>
                            </div>              
                        </div>
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="version">{{ __("Version") }}:</label>
                                <input type="text" class="form-control date" name="version" value="{{ old('version') }}"/>
                            </div>
                            <div class="col-lg form-group">
                                <label for="version">{{ __("Released At") }}:</label>
                                <input type="text" class="form-control datepicker" name="released_at" value="{{ old('released_at') ?? date(config('app.php_date_format'))  }}"/>
                            </div>                         
                        </div>                       
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="contact_number">{{ __("Description") }}:</label>
                                <textarea rows="10" class="form-control" name="description">{{ old('description') }}</textarea>
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-lg">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" name="forced_update" id="forced_update" {{ old('forced_update') ? "checked" : "" }} />
                                    <label class="form-check-label" for="forced_update">{{ __("Forced Update") }}</label>
                                </div>
                            </div>
                           
                        </div>                     
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{__("Create New")}} {{ __("Mobile App Version") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.app_versions.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Mobile App Version") }} {{__("List")}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
