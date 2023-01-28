@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h4>Purchaes Request: {{ $purchase_request->code }}</h4>
            <hr />
        </div>
    </div>  

    @if (session('status'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        </div>
    </div>
    @endif    
    @if ($errors->any())
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                      
                            <div class="form-group">
                                <label for="created_at">Request Date:</label>
                                <input type="text" id="created_at" class="form-control" value="{{ $purchase_request->created_at->toSystemDateString() }}" readonly />
                            </div>
                            <div class="form-group">
                                <label for="purchase_request_project_id">Project:</label>
                                <input type="text" id="purchase_request_project_id" class="form-control" readonly value="{{ $purchase_request->purchaseRequestProject->name }}">
                               
                            </div>
                            <div class="form-group">
                                <label for="department_id">Department:</label>
                                <input type="text" id="department_id" class="form-control" readonly value="{{ $purchase_request->department->name }}">
                            </div>
                            <div class="form-group'">
                                <label for="mrp_no">MRP No.</label>
                                <input type="text" id="mrp_no" class="form-control" value="{{ old('mrp_no', $purchase_request->mrp_no) }}" readonly>
                            </div>                    
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shipment_contact_name">Shipment Contact Name</label>
                                <input type="text" class="form-control" id="shipment_contact_name" value="{{ old('shipment_contact_name', $purchase_request->shipment_contact_name) }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label for="shipment_contact_number">Shipment Contact Number:</label>
                                <input type="text" class="form-control" id="shipment_contact_number" value="{{ old('shipment_contact_number', $purchase_request->shipment_contact_number) }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label for="shipment_address_line1">Shipment Address Line 1:</label>
                                <input type="text" class="form-control" id="shipment_address_line1" value="{{ old('shipment_address_line1', $purchase_request->shipment_address_line1) }}" readonly/>
                            </div>
                            <div class="form-group'">
                                <label for="shipment_address_line2">Shipment Address Line 2:</label>
                                <input type="text" class="form-control" id="shipment_address_line2" value="{{ old('shipment_address_line2', $purchase_request->shipment_address_line2) }}" readonly/>
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-3">
            <table class="table table-bordered bg-white mb-0 mt-3" id="table_item">
                <thead>
                    <tr class="text-center">                        
                        <th width="150px">{{ __('Item code') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th width="100px">{{ __('UOM') }}</th>
                        <th width="100px">{{ __('QTY') }}</th>
                        <th width="200px">{{ __('Expected Arrival Date') }}</th>
                        <th width="200px">{{ __('Purpose') }}</th>
                        <th width="200px">{{ __('Staff ID') }}</th>
                    </tr>
                </thead>
                
                <tbody id="table_body" class="mainbody">                   
                    @foreach( $purchase_request->purchaseRequestDetails as $key => $value )
                    <tr class="text-center" >                                
                        <td>{{ $value['item_code'] }}</td>
                        <td class="text-left">{{ $value['description'] }}</td>
                        <td>{{ $value['unit_of_measurement'] }}</td>
                        <td>{{ $value['quantity'] }}</td>
                        <td>{{ $value['expected_arrival_date']->toSystemDateString() }}</td>
                        <td class="text-left">{{ $value['purpose'] }}</td>
                        <td>{{ $value['staff_id'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>         
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="remark">Remark:</label>
                        {{ $purchase_request->remark }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header">
                    Attachments
                </div>
                <div class="card-body">
                    <div id="attachment_container">
                        @foreach($purchase_request->media as $media)
                        <div class="d-flex my-2 p-2 bg-light media-container">
                            <img src="{{ $media->getTypeFromExtension() == 'image' ?  $media->getUrl('thumb') : asset('img/file-icon.jpg') }}" class="img-thumbnail">
                            <div class="p-2 flex-grow-1">
                                <span class="d-inline-block">Name: {{ $media->name.'.'.$media->extension }}</span>
                                <span class="d-block">Type: {{ $media->getTypeFromExtension() }}, Size: {{ $media->human_readable_size }}</span>
                            </div>
                            <div class="align-self-center">
                                <a href="{{ $media->getFullUrl() }}" class="btn btn-sm btn-success" target="_blank"><i class="far fa-eye"></i> View</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if( $purchase_request->approvals->count() > 0 )    
    <div class="row" id="approval">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    Approval
                </div>
                <div class="card-body">
                    @foreach( $purchase_request->approvals as $approval )                     
                    <div class="d-flex bg-light p-2 border my-2 w-100">
                        <div class="flex-fill">
                            <span><strong>{{ $approval->approver->name }}</strong></span>
                            <i class="fas fa-arrow-right"></i>
                            <span class="badge badge-pill badge-secondary">{{ $approval->status }}</span>
                        </div>
                        @if( is_null($purchase_request->approval->action) 
                            AND (Auth::user()->id == $purchase_request->approval->user_id) 
                            AND ($purchase_request->approval->user_id == $approval->user_id)
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
                                        <form id="approve-form" method="post" action="{{ route('purchase_requests.approve', ['id' => $purchase_request->id]) }}">
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
                                        <form id="reject-form" method="post" action="{{ route('purchase_requests.reject', ['id' => $purchase_request->id]) }}">
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
                                        <form id="sendBack-form" method="post" action="{{ route('purchase_requests.sendBack', ['id' => $purchase_request->id]) }}">
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

                    @if( $purchase_request->approval AND $purchase_request->approval->action AND is_null($purchase_request->approval->next_approval_id) )
                    <div class="d-flex">
                        <a href="{{ route('purchase_requests.print', [ 'id'=> $purchase_request->id ]) }}" class="btn btn-sm btn-primary mx-auto">Print</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
             <div class="card">
                <div class="card-header">
                    Comment
                </div>
                <div class="card-body" style="">
                      <purchase-request-comment-list purchase-request-id="{{ $purchase_request->id }}"></purchase-request-comment-list>
                </div>
            </div>      
        </div>    
    </div>
</div>


@endsection

@push('scripts')
@endpush

