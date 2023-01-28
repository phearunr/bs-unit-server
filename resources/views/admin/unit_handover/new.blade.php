@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
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
<form method="POST" action="{{ route('admin.unit_handovers.store') }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data">
    @csrf
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{__("Unit Handover")}}
                    <button type="button" class="btn btn-link float-right" data-toggle="collapse" data-target="#post-body" aria-controls="post-body" aria-expanded="true">
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <div id="post-body" class="collapse show" aria-labelledby="{{ __('Post') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="unit_code">{{ __('Unit Code') }}:</label>
                                <input type="text" name="unit_code" id="unit_code" class="form-control" value="{{$unit->code}}" disabled>
                                <input type="hidden" name="unit_id" id="unit_id" class="form-control" value="{{$unit->id}}">
                            </div>
                            <div class="col-lg form-group">
                                <label for="date">{{ __('Date') }}:</label>
                                <input type="text" class="form-control datepicker" name="date" id="date" aria-label=" Date" aria-describedby="addon-wrapping" value="{{ old('date') ?? date(config('app.php_date_format')) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="customer_name">{{ __('Customer Name 1') }}:</label>
                                <input type="text" name="customer_name" id="customer_name" class="form-control"  value="{{ old('customer_name') }}">
                            </div>
                            <div class="col-lg form-group">
                                <label for="customer_relationship">{{ __('Customer Relationship') }}:</label>
                                <select name="customer_relationship" id="customer_relationship" class="form-control">
                                    <option value="">Select Relationship</option>
                                    <option value="Owner" >Owner</option>
                                    <option value="Col-Owner">Col-Owner</option>
                                    <option value="Relative">Relative</option>
                                 
                                </select>
                            <!-- //<input type="text" name="customer_relationship" id="customer_relationship" class="form-control" > -->
                            </div>
                            <div class="col-lg form-group">
                                <label for="date">{{ __('Agree on a date') }}:</label>
                                <input type="text" class="form-control datepicker" name="agreement_date" id="agreement_date" aria-label=" Date" aria-describedby="addon-wrapping" value="{{ old('agreement_date') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="customer_name2">{{ __('Customer Name 2') }}:</label>
                                <input type="text" name="customer_name2" id="customer_name2" class="form-control"  value="{{ old('customer_name2') }}">
                            </div>
                            <div class="col-lg form-group">
                                <label for="customer_relationship2">{{ __('Customer Relationship 2') }}:</label>
                                <!-- <input type="text" name="customer_relationship2" id="customer_relationship2" class="form-control" > -->
                                <select name="customer_relationship2" id="customer_relationship2" class="form-control">
                                    <option value="">Select Relationship</option>
                                    <option value="Owner">Owner</option>
                                    <option value="Col-Owner">Col-Owner</option>
                                    <option value="Relative">Relative</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">  
                                <label for=""> {{ __('Appointment')  }}</label>                            
                                <input type="file" class="form-control-file" name="appointment_image_url" id="appointment_image_url" value="{{ old('appointment_image_url') }}" />
                                <small class="form-text text-muted">{{ __('File pdf must be : 1000KB') }}</small>
                            </div>
                            <div class="col-lg">  
                                <label for="">  {{ __('Handover Letter')  }} </label>                            
                                <input type="file" class="form-control-file" name="handover_letter_image_url" id="handover_letter_image_url" value="{{ old('handover_letter_image_url') }}" />
                                <small class="form-text text-muted">{{ __('File pdf must be : 1000KB') }}</small>
                            </div>
                            <div class="col-lg">     
                                <label for=""> {{ __('Letter of Assignment of Real Estate')  }}      </label>                         
                                <input type="file" class="form-control-file" name="lor_image_url" id="lor_image_url" value="{{ old('lor_image_url') }}" />
                                <small class="form-text text-muted">{{ __('File pdf must be : 1000KB') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary">{{__("Create")}} {{ __("Unit Handover") }}</button>
                        </div>
                        <div class="col">
                            <a href="{{ URL::previous() }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Unit") }} {{__("List")}}</a>
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
