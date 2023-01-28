@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.discount_promotions.store') }}" novalidate="novalidate" autocomplete="false">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{__("Discount Promotion")}}</div>
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
                            <div class="form-group col">
                                <label for="name">{{ __('Name') }}: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                            </div>                           
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="start_date">{{ __('Start Date') }}:</label>
                                <input type="text" class="form-control datepicker" name="start_date" id="start_date" value="{{ old('start_date') }}">
                            </div>
                            <div class="form-group col">
                                <label for="end_date">{{ __('End Date') }}:</label>
                                <input type="text" class="form-control datepicker" name="end_date" id="end_date" value="{{ old('end_date') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="amount">{{ __('Discount Amount') }}:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend3">$</span>
                                    </div>
                                    <input type="text" class="form-control" name="amount" id="amount" value="{{ old('amount') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{__("Create")}} {{ __("Discount Promotion") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.discount_promotions.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Discount Promotion List") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
@endpush
