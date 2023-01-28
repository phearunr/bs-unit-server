@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.construction_procedures.update', ['id' => $construction_procedure->id]) }}" novalidate="novalidate" autocomplete="false">
        @csrf   
        {{ method_field('PUT') }}     
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{__("Construction Procedure")}} : {{ $construction_procedure->name }}</div>
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
                            <div class="form-group col-sm-12">
                                <label for="name_km">{{ __('Name In Khmer') }}: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name_km" id="name" value="{{ old('name_km') ?? $construction_procedure->name_km }}">
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="name_km">{{ __('Name In English') }}: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') ?? $construction_procedure->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{ __("Update") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.construction_procedures.index') }}" class="btn btn-secondary float-right">{{ __("Back") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
