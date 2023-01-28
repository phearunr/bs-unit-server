@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.payment_options.update', [ 'id' => $payment_option->id ]) }}" novalidate="novalidate" autocomplete="false">
    @csrf        
    {{ method_field("PUT") }}
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __("Edit") }} {{__("Payment Option")}} : <strong>{{ $payment_option->name }}</strong></div>
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
                        <div class="form-group">
                            <label for="name">Name: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" 
                                   placeholder="Full Loan 36 Months" 
                                   value="{{ $payment_option->name }}">
                        </div>
                        <div class="form-group">
                            <label for="unit_type_id">Unit Type <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="unit_type_id" id="unit_type_id">
                                @foreach ( $projects as $project )
                                    <optgroup label="{{ $project->name }}">
                                    @foreach( $project->unitTypes as $unit_type )
                                        <option value="{{ $unit_type->id }}" 
                                                {{ $unit_type->id == $payment_option->unit_type_id ? "selected" : "" }} >
                                                {{ $unit_type->name }} ({{ $project->name }})
                                        </option>
                                    @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <small id="unit_type_id_help" class="form-text text-info">Changing the Unit Type could result data mis-match problem, if this unit type has been associate with other object. Modify this attribute with care.</small>
                        </div>
                        <div class="form-group">
                            <label for="deposit_amount">Initial Deposit Amount <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="deposit_amount" id="deposit_amount" 
                                   placeholder="The amount customer need to make first deposit. eg : 0" 
                                   value="{{ $payment_option->deposit_amount }}">
                        </div>  
                        <div class="row">
                            <div class="col">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="first_payment_checkbox" name="is_first_payment" data-toggle="collapse" href="#first_payment_container" {{ $payment_option->is_first_payment ? "checked" : "" }}>
                                    <label class="form-check-label" for="first_payment_checkbox">First Payment Plan</label>
                                </div>
                            </div>
                        </div>
                        <div class="row collapse {{ $payment_option->is_first_payment ? 'show' : 'closed'}}" id="first_payment_container">
                            <div class="col-lg">
                                <div class="form-group">
                                    <label for="first_payment_duration">First Payment Duraction (Month): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="first_payment_duration" id="first_payment_duration" 
                                           placeholder="0" min="0"
                                           value="{{ $payment_option->first_payment_duration }}">
                                    <small id="loan_duration_help" class="form-text text-muted">Number Only</small>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="form-group">
                                    <label for="first_payment_percentage">First Payment Percentage: <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="first_payment_percentage" id="first_payment_percentage" 
                                           placeholder="0" min="0" max="100"
                                           value="{{ $payment_option->first_payment_percentage }}">
                                    <small id="first_payment_percentage_help" class="form-text text-muted">Number Only</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="form-group">
                                    <label for="loan_duration">Loan Duration (Month): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="loan_duration" id="loan_duration" 
                                           placeholder="0" 
                                           value="{{ $payment_option->loan_duration }}">
                                    <small id="loan_duration_help" class="form-text text-muted">Number Only</small>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="form-group">
                                    <label for="interest">Interest Per Year (%): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="interest" id="interest" 
                                           placeholder="0" 
                                           value="{{ $payment_option->interest }}">
                                    <small id="interest_help" class="form-text text-muted">Number Only</small>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="form-group">
                                    <label for="special_discount">Special Discount (%): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="special_discount" id="special_discount" 
                                           placeholder="0" 
                                           value="{{ $payment_option->special_discount }}">
                                    <small id="special_discount_help" class="form-text text-muted">Number Only</small>
                                </div>
                            </div>
                        </div>                                             
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{ __("Update") }} {{ __("Payment Option") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.payment_options.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Payment Option") }} {{__("List")}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push("scripts")
<script type="text/javascript">
    $(document).ready(function (){
        $('.select2').select2({ theme:"bootstrap4" });
    });
</script>
@endpush
