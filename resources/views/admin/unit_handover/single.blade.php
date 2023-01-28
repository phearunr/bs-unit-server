
@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
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
                    <form method="POST" action="" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data">
                     @csrf
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="unit_code">{{ __('Unit Code') }}:</label>
                                <input type="text" name="unit_code" id="unit_code" class="form-control" value="{{$unit_handover->Unit->code}}" disabled>
                            </div>
                            <div class="col-lg form-group">
                                <label for="date">{{ __('Date') }}:</label>
                                <input type="text" class="form-control datepicker" name="date" id="date" value="{{ $unit_handover->date->toSystemDateString() }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="customer_name">{{ __('Customer Name') }}:</label>
                                <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{$unit_handover->customer_name}}" disabled>
                            </div>
                            <div class="col-lg form-group">
                                <label for="customer_relationship">{{ __('Customer Relationship') }}:</label>
                                <input type="text" name="customer_relationship" id="customer_relationship" class="form-control" value="{{$unit_handover->customer_relationship}}"disabled >
                            </div>
                            <div class="col-lg form-group">
                                <label for="date">{{ __('Agree on a date') }}:</label>
                                <input type="text" class="form-control datepicker" name="agreement_date" id="agreement_date" value="{{ $unit_handover->agreement_date->toSystemDateString() }}" disabled >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="customer_name2">{{ __('Customer Name 2') }}:</label>
                                <input type="text" name="customer_name2" id="customer_name2" class="form-control" value="{{$unit_handover->customer_name2}}" disabled>
                            </div>
                            <div class="col-lg form-group">
                                <label for="customer_relationship2">{{ __('Customer Relationship 2') }}:</label>
                                <input type="text" name="customer_relationship2" id="customer_relationship2" class="form-control" value="{{$unit_handover->customer_relationship2}}"disabled >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">    
                                <label for=""> {{ __('Appointment')  }}  </label>   
                                <figure class="figure mb-0 border">
                                    <embed type="application/pdf" src="{{ asset('storage/' .$unit_handover->appointment_image_url) }}"></embed>
                                </figure>
                                <div class="d-block py-2">
                                    <a href="{{ asset('storage/' .$unit_handover->appointment_image_url) }}" class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-eye"></i> View</a>
                                </div>
                            </div>
                            <div class="col-lg">   
                                <label for=""> {{ __('Handover Letter')  }} </label>
                                <figure class="figure mb-0 border">
                                    <embed type="application/pdf" src="{{ asset('storage/' .$unit_handover->handover_letter_image_url) }}"></embed>
                                </figure>
                                <div class="d-block py-2">
                                    <a href="{{ asset('storage/' .$unit_handover->handover_letter_image_url) }}" class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-eye"></i> View</a>
                                </div>
                            </div>
                            <div class="col-lg">      
                                <label for=""> {{ __('Letter of Assignment of Real Estate')  }}</label>  
                                <figure class="figure mb-0 border">
                                    <embed type="application/pdf" src="{{ asset('storage/' .$unit_handover->lor_image_url) }}"></embed>
                                </figure>
                                <div class="d-block py-2">
                                    <a href="{{ asset('storage/' .$unit_handover->lor_image_url) }}" class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-eye"></i> View</a>
                                </div>                                
                            </div>
                        </div>  
                    </form>
                </div>    
            </div>
        </div>
         @if( $unit_handover->approvals->count() > 0 )    
            <div class="row" id="approval">
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            Approval
                        </div>
                    <div class="card-body">
                    @foreach($unit_handover->approvals as $approval )                     
                    <div class="d-flex bg-light p-2 border my-2 w-100">
                        <div class="flex-fill">
                            <span><strong>{{$approval->approver->name }}</strong></span>
                            <i class="fas fa-arrow-right"></i>
                            <span class="badge badge-pill badge-secondary">{{ $approval->status }}</span>
                        </div>
                    @if( is_null($unit_handover->approval->action) 
                    AND (Auth::user()->id == $unit_handover->approval->user_id) 
                    AND ($unit_handover->approval->user_id == $approval->user_id)
                    )
                    <div class="">
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#approveModal">
                            {{ ucfirst(strtolower($approval->action_true)) }}
                        </button>                  
                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#rejectModal">{{ ucfirst(strtolower($approval->action_false)) }}</button>
                        <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#sendBackModal">Send Back</button>
                    </div>
                                                <!-- Approval Modal -->
                    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Remark</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="approve-form" method="post" action="{{ route('admin.unit_handovers.approve', ['id' =>$unit_handover->id]) }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="remark" class="col-form-label">Please type your remark below <span class="text-danger">*</span>:</label>
                                            <textarea class="form-control" name="remark" id="remark" rows="5" required></textarea>
                                            <small id="remarkHelp" class="form-text text-muted">Your action will be record as log in the comment section.</small>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" form="approve-form" class="btn btn-primary">{{ ucfirst(strtolower($approval->action_true)) }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                                                <!-- Reject Modal -->
                    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Remark</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                                <div class="modal-body">
                                    <form id="reject-form" method="post" action="{{ route('admin.unit_handovers.reject', ['id' =>$unit_handover->id]) }}">
                                    @csrf
                                        <div class="form-group">
                                            <label for="remark" class="col-form-label">Please type your remark below <span class="text-danger">*</span></label>
                                            <textarea class="form-control" name="remark" id="remark" rows="5" required></textarea>
                                            <small id="remarkHelp" class="form-text text-muted">Your action will be record as log in the comment section.</small>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" form="reject-form" class="btn btn-danger">{{ ucfirst(strtolower($approval->action_false)) }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                                                <!-- Send back Modal -->
                    <div class="modal fade" id="sendBackModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Remark</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="sendBack-form" method="post" action="{{ route('admin.unit_handovers.sendBack', ['id' =>$unit_handover->id]) }}">
                                    @csrf
                                        <div class="form-group">
                                            <label for="remark" class="col-form-label">Please type your remark below <span class="text-danger">*</span>:</label>
                                            <textarea class="form-control" name="remark" id="remark" rows="5" required></textarea>
                                            <small id="remarkHelp" class="form-text text-muted">Your action will be record as log in the comment section.</small>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" form="sendBack-form" class="btn btn-secondary">Send Back</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="">
                        <span class="badge badge-pill badge-{{ is_null($approval->action) ? 'info' : ($approval->action ? 'success' : 'danger') }}">{{ $approval->status_label }}</span>
                    </div> 
                    @endif
                    </div>
                    @if (!$loop->last)
                    <i class="d-block text-center fas fa-arrow-down"></i>
                    @endif
                    @endforeach
                    @if($unit_handover->approval AND $unit_handover->approval->action AND is_null($unit_handover->approval->next_approval_id) )
                        
                    @endif
                </div>
            </div>
        @endif
        <div class="row">
        <div class="col-md-12">
             <div class="card">
                <div class="card-header">
                    Comment
                </div>
                <div class="card-body">
                    <unit-handover-request-comment-list :id="{{ $unit_handover->id }}"></unit-handover-request-comment-list>
                </div>
            </div>      
        </div>    
    </div>
   </div>           
</div>

@endsection

@push('scripts')
@endpush