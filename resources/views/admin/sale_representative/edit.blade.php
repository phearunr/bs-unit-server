@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.sale_representatives.update', ['id' => $sale_representative->id]) }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data">
    @csrf        
    {{ method_field("PUT") }}
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{__("Sale Representative")}} : {{ __("Create New") }}</div>
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
                                <label for="">Name:</label>
                                <input type="text" name="name" class="form-control" value="{{ $sale_representative->name }}">
                            </div>
                            <div class="col-lg form-group">
                                <label for="">Name (English)</label>
                                <input type="text" name="name_en" class="form-control" value="{{ $sale_representative->name_en }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="gender">Gender:</label>
                                <select name="gender" class="form-control">
                                    <option value="Male" {{ $sale_representative->gender == "Male" ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $sale_representative->gender == "Female" ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="col-lg form-group">
                                <label for="brith_date">Birth Date:</label>
                                <input type="text" name="birth_date" class="form-control datepicker" value="{{ $sale_representative->birth_date->toSystemDateString() }}">
                            </div>
                            <div class="col-lg form-group">
                                <label for="national_id">National ID:</label>
                                <input type="text" name="national_id" class="form-control" value="{{ $sale_representative->national_id }}">
                            </div>
                            <div class="col-lg form-group">
                                <label for="national_id_issued_date">Issued Date:</label>
                                <input type="text" name="national_id_issued_date" class="form-control datepicker" value="{{ $sale_representative->national_id_issued_date->toSystemDateString() }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="contact_number">Contact Number:</label>
                                <input type="text" name="contact_number" class="form-control" value="{{ $sale_representative->contact_number }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="national_id_front_attachment_url">National Front</label>
                                <input type="file" name="national_id_front_attachment_url" class="form-control-file">
                                @if($sale_representative->national_id_front_attachment_url)
                                <figure class="figure border">
                                    <a href="{{ $sale_representative->national_id_front_attachment_url }}" target="_blank">
                                        <img src="{{ $sale_representative->national_id_front_attachment_url }}" class="figure-img img-fluid">
                                    </a>                            
                                </figure>
                                @endif
                            </div>
                            <div class="col-lg form-group">
                                <label for="national_id_back_attachment_url">National Back</label>
                                <input type="file" name="national_id_back_attachment_url" class="form-control-file"> @if($sale_representative->national_id_back_attachment_url)
                                <figure class="figure border">
                                    <a href="{{ $sale_representative->national_id_back_attachment_url }}" target="_blank">
                                        <img src="{{ $sale_representative->national_id_back_attachment_url }}" class="figure-img img-fluid">
                                    </a>                            
                                </figure>
                                @endif
                            </div>
                            <div class="col-lg form-group">
                                <label for="authorize_letter_url">National Back</label>
                                <input type="file" name="authorize_letter_url" class="form-control-file"> @if($sale_representative->authorize_letter_url)
                                <figure class="figure border">
                                    <a href="{{ $sale_representative->authorize_letter_url }}" target="_blank">
                                        <img src="{{ $sale_representative->authorize_letter_url }}" class="figure-img img-fluid">
                                    </a>                            
                                </figure>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{__("Update")}} {{ __("Sale Representative") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.sale_representatives.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Sale Representative") }} {{__("List")}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
