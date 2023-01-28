@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('site_manager.unit_handovers.update',['id'=>$handover->id]) }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row justify-content-center">
        <div class="col-md-12 mb-3">
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
                                <input type="text" name="unit_code" id="unit_code" class="form-control" value="{{$handover->Unit->code}}" disabled>
                            </div>
                            <div class="col-lg form-group">
                                <label for="date">{{ __('Date') }}:</label>
                                <input type="text" class="form-control datepicker" name="date" id="date" aria-label=" Date" aria-describedby="addon-wrapping" value="{{$handover->date->toSystemDateString()}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="customer_name">{{ __('Customer Name') }}:</label>
                                <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{$handover->customer_name}}" >
                            </div>
                            <div class="col-lg form-group">
                                <label for="customer_relationship">{{ __('Customer Relationship') }}:</label>
                                <!-- <input type="text" name="customer_relationship" id="customer_relationship" class="form-control" value="{{$handover->customer_relationship}}" > -->
                                <select name="customer_relationship" id="customer_relationship" class="form-control">
                                    <option value="">Select Relationship</option>
                                    <option value="Owner" {{($handover->customer_relationship === 'Owner') ? 'Selected' : ''}}>Owner</option>
                                    <option value="Col-Owner" {{($handover->customer_relationship === 'Col-Owner') ? 'Selected' : ''}}>Col-Owner</option>
                                    <option value="Relative" {{($handover->customer_relationship === 'Relative') ? 'Selected' : ''}}>Relative</option>
                                </select>
                            </div>
                            <div class="col-lg form-group">
                                <label for="date">{{ __('Agree on a date') }}:</label>
                                <input type="text" class="form-control datepicker" name="agreement_date" id="agreement_date" aria-label=" Date" aria-describedby="addon-wrapping" value="{{$handover->agreement_date->toSystemDateString()}}" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="customer_name2">{{ __('Customer Name 2') }}:</label>
                                <input type="text" name="customer_name2" id="customer_name2" class="form-control" value="{{$handover->customer_name2}}" >
                            </div>
                            <div class="col-lg form-group">
                                <label for="customer_relationship2">{{ __('Customer Relationship 2') }}:</label>
                                <!-- <input type="text" name="customer_relationship2" id="customer_relationship2" class="form-control" value="{{$handover->customer_relationship2}}" > -->
                                <select name="customer_relationship2" id="customer_relationship2" class="form-control">
                                    <option value="">Select Relationship</option>
                                    <option value="Owner" {{($handover->customer_relationship2 === 'Owner') ? 'Selected' : ''}}>Owner</option>
                                    <option value="Col-Owner" {{($handover->customer_relationship2 === 'Col-Owner') ? 'Selected' : ''}}>Col-Owner</option>
                                    <option value="Relative" {{($handover->customer_relationship2 === 'Relative') ? 'Selected' : ''}}>Relative</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">    
                                <label for="appointment_image_url">{{ __('Appointment')  }}</label>
                                <figure class="figure mb-0 border">
                                    <embed type="application/pdf" src="{{ asset('storage/' .$handover->appointment_image_url) }}"></embed>
                                </figure>
                                <div class="d-block py-2">
                                    <a href="{{ asset('storage/' .$handover->appointment_image_url) }}" class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-eye"></i> View</a>
                                </div>
                                <input type="file" class="form-control-file" name="appointment_image_url" id="appointment_image_url" id="appointment_image_url"/>
                                <small class="form-text text-muted">{{ __('File pdf must be : 1000KB') }}</small>
                            </div>
                            <div class="col-lg-4">   
                                <label for=""> {{ __('Handover Letter')  }} </label>     
                                <figure class="figure mb-0 border">
                                    <embed type="application/pdf" src="{{ asset('storage/' .$handover->handover_letter_image_url) }}"></embed>
                                </figure>
                                <div class="d-block py-2">
                                    <a href="{{ asset('storage/' .$handover->handover_letter_image_url) }}" class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-eye"></i> View</a>
                                </div>
                                <input type="file" class="form-control-file" name="handover_letter_image_url" id="handover_letter_image_url" />
                                <small class="form-text text-muted">{{ __('File pdf must be : 1000KB') }}</small>
                            </div>
                            <div class="col-lg-4">
                                <label for=""> {{ __('Letter of Assignment of Real Estate')  }}</label> 
                                <figure class="figure mb-0 border">
                                    <embed type="application/pdf" src="{{ asset('storage/' .$handover->lor_image_url) }}"></embed>
                                </figure>
                                <div class="d-block py-2">
                                    <a href="{{ asset('storage/' .$handover->lor_image_url) }}" class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-eye"></i> View</a>
                                </div>
                                <input type="file" class="form-control-file" name="lor_image_url" id="lor_image_url" />
                                <small class="form-text text-muted">{{ __('File pdf must be : 1000KB') }}</small>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{__("Update")}} {{ __("Unit Handover") }}</button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Approvals</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('site_manager.unit_handovers.send_approval', ['id' =>$handover->id]) }}" id="send-approval-form">
                        @csrf
                        @foreach($approval_workflows as $approval_workflow)
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">{{ $approval_workflow->action_true }} By: </label>
                            <div class="col-sm-8">
                                <input type="hidden" name="workflow[{{ $loop->index }}][workflow_id]" value="{{ $approval_workflow->id }}"> 
                                <select class="form-control" name="workflow[{{ $loop->index }}][user_id]">
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endforeach
                    </form>  
                </div>
                <div class="card-footer">
                    <a href="javascript:void()" class="btn btn-success" onclick="event.preventDefault();
                                document.getElementById('send-approval-form').submit();">
                        Send for Approval</a>
                    </div>
                </div>
            </div>
        </div>
    </div>           
</div>
@endsection

@push('scripts')

@endpush