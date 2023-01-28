@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h4>Edit Purchaes Request: {{ $purchase_request->code }}</h4>
            <hr>
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
    @if ($count = Session::get('count') AND $count->count() > 0)
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-warning" role="alert">
                @foreach( $count->toArray() as $key => $value ) 
                Staff ID: {{$key}} <span>related request</span> {{$value}} <span><a href="{{ route('purchase_request_details.index', ['staff_id' => $key]) }}" >More....</a></span>   
                @endforeach
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

    <form method="POST" action="{{ route('purchase_requests.update', ['id' => $purchase_request->id]) }}" id="updatePurchaseRequestForm">
    @csrf  
    @method('PUT')
    <input type="hidden" id="purchase_request_id" value="{{ $purchase_request->id }}">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                      
                            <div class="form-group">
                                <label for="requested_date">Request Date:</label>
                                <input type="text" class="form-control" value="{{ $purchase_request->created_at->toSystemDateString() }}" readonly />
                            </div>
                            <div class="form-group">
                                <label for="purchase_request_project_id">Project <span class="text-danger">*</span>:</label>
                                <select class="form-control" id="purchase_request_project_id" name="purchase_request_project_id">
                                    @foreach($purchase_request_projects as $purchase_request_project)
                                    <option value="{{ $purchase_request_project->id }}" {{ (old('purchase_request_project_id', $purchase_request->purchase_request_project_id) == $purchase_request_project->id) ? 'selected' : '' }}>{{ $purchase_request_project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="department_id">Department <span class="text-danger">*</span>:</label>
                                <select class="form-control" id="department_id" name="department_id">
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ (old('department_id', $purchase_request->department_id) == $department->id) ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group'">
                                <label for="mrp_no">MRP No.</label>
                                <input type="text" name="mrp_no" id="mrp_no" class="form-control" value="{{ old('mrp_no', $purchase_request->mrp_no) }}">
                            </div>                    
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shipment_contact_name">Shipment Contact Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="shipment_contact_name" id="shipment_contact_name" value="{{ old('shipment_contact_name', $purchase_request->shipment_contact_name) }}" />
                            </div>
                            <div class="form-group">
                                <label for="shipment_contact_number">Shipment Contact Number <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control" name="shipment_contact_number" id="shipment_contact_number" value="{{ old('shipment_contact_number', $purchase_request->shipment_contact_number) }}" />
                            </div>
                            <div class="form-group">
                                <label for="shipment_address_line1">Shipment Address Line 1 <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control" name="shipment_address_line1" id="shipment_address_line1" value="{{ old('shipment_address_line1', $purchase_request->shipment_address_line1) }}"/>
                            </div>
                            <div class="form-group'">
                                <label for="shipment_address_line2">Shipment Address Line 2:</label>
                                <input type="text" class="form-control" name="shipment_address_line2" id="shipment_address_line2" value="{{ old('shipment_address_line2', $purchase_request->shipment_address_line2) }}" />
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
                        <th width="170px">{{ __('Item code') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th width="100px">{{ __('UOM') }}</th>
                        <th width="100px">{{ __('QTY') }}</th>
                        <th width="130px">{{ __('Expected Arrival Date') }}</th>
                        <th width="200px">{{ __('Purpose') }}</th>
                        <th width="150px">{{ __('Staff ID') }}</th>
                        <th width="50px">
                            <button type="button" class="btn btn-primary" name="add" id="btnAddItem"><i class="fa fa-plus"></i></button>
                        </th>
                    </tr>
                </thead>
                
                <tbody id="table_body" class="mainbody">                    
                    @foreach( old('purchase_request_details', $purchase_request->purchaseRequestDetails) as $key => $value )
                        <tr class="text-center">                                
                            <td><input type="text" name="purchase_request_details[{{$key}}][item_code]" class="form-control" value="{{ $value['item_code'] }}"></td>
                            <td><textarea rows="3" class="form-control" name="purchase_request_details[{{$key}}][description]">{{ $value['description'] }}</textarea></td>
                            <td><input type="text" name="purchase_request_details[{{$key}}][unit_of_measurement]" class="form-control" value="{{ $value['unit_of_measurement'] }}"></td>
                            <td><input type="number" name="purchase_request_details[{{$key}}][quantity]" class="form-control" step="any" value="{{ $value['quantity'] }}"></td>
                            <td><input type="text" name="purchase_request_details[{{$key}}][expected_arrival_date]" class="form-control datepicker" value="{{ old('purchase_request_details') ?  $value['expected_arrival_date'] : $value['expected_arrival_date']->toSystemDateString() }}"></td>
                            <td><textarea rows="3" class="form-control" name="purchase_request_details[{{$key}}][purpose]">{{ $value['purpose'] }}</textarea></td>
                            <td><input type="text" name="purchase_request_details[{{$key}}][staff_id]" class="form-control" value="{{ $value['staff_id'] }}"></td>
                            <td><button class="btn btn-sm btn-danger btn-remove-table-item"><i class="fa fa-trash"></i></button></td>
                        </tr>
                    @endforeach                  
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="flex border-bottom mb-3">
                        <label>Attachments:</label>
                        <div class="float-right">
                            <input type="file" id="add_attachment_button" class="d-none"> 
                            <label for="add_attachment_button" class="btn btn-primary btn-sm">Add</label>
                        </div>
                    </div>
                    <div id="attachment_container">
                        @foreach($purchase_request->media as $media)
                        <div class="d-flex my-2 p-2 bg-light media-container">
                            <img src="{{ $media->getTypeFromExtension() == 'image' ?  $media->getUrl('thumb') : asset('img/file-icon.jpg') }}" class="img-thumbnail">
                            <div class="p-2 flex-grow-1">
                                <span>Name: {{ $media->name.'.'.$media->extension }}</span>
                                <span class="d-block">Type: {{ $media->getTypeFromExtension() }}, Size: {{ $media->human_readable_size }}</span>
                            </div>
                            <div class="align-self-center">
                                <a href="{{ $media->getFullUrl() }}" class="btn btn-sm btn-success" target="_blank"><i class="far fa-eye"></i> View</a>
                                <button class="btn btn-sm btn-danger btn-remove-media" data-id="{{ $media->id }}"><i class="far fa-trash-alt"></i> Delete</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="remark">Remark <span class="text-danger">*</span>:</label>
                        <textarea class="form-control" name="remark" id="remark" rows="3">{{ old('remark', $purchase_request->remark) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form> 
    
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-body">
                    <div class="flex border-bottom mb-3">
                        <label>Approval:</label> 
                    </div>
                    <form method="POST" action="{{ route('purchase_requests.send_approval', ['id' => $purchase_request->id]) }}" id="send-approval-form">
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
            </div>
        </div>
    </div>

    @if($purchase_request->status == 'Draft')         
    <div class="row">
        <div class="col-md-12 mt-3">
            <button type="submit" class="btn btn-primary" form="updatePurchaseRequestForm">Update</button>   
            <a href="javascript:void()" 
                class="btn btn-success float-right"
                onclick="event.preventDefault();
                         document.getElementById('send-approval-form').submit();">
            Send for Approval</a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    function appendMedia(parent_ele, media) {
        var icon = "{{ asset('img/file-icon.jpg') }}";
        var extension = media.file_name.split('.').pop();
        if ( media.mime_type.includes('image') ) {
            icon = media.thumbnail_url;
        }
        var html = `<div class="d-flex my-2 p-2 bg-light media-container">
                            <img src="${icon}" class="img-thumbnail">
                            <div class="p-2 flex-grow-1">
                                <span>Name: ${media.name}.${extension}</span>
                                <span class="d-block">Type: ${extension}, Size: ${media.human_readable_size}</span>
                            </div>
                            <div class="align-self-center">
                                <a href="${media.url}" class="btn btn-sm btn-success" target="_blank"><i class="far fa-eye"></i> View</a>
                                <button class="btn btn-sm btn-danger btn-remove-media" data-id="${media.id}"><i class="far fa-trash-alt"></i> Delete</button>
                            </div>
                        </div>`;
        parent_ele.append(html);
    }

    $(document).on('click', '.btn-remove-media', function (e) {
        e.preventDefault(); 

        var purchase_request_id = $('#purchase_request_id').val();
        var ele = $(this);        
        var media_id =  ele.data('id')
        var url = `/purchase_requests/${purchase_request_id}/media/${media_id}`;

        axios.post(url, {
            '_method' : 'DELETE',
        }).then( function (response) {           
            if ( response.status == 200 ) {
                ele.closest('.media-container').remove();  
            }
        })
        .catch( function ( error ){           
            Swal.fire(
                'Error',
                error.response.data.message,
                'error'
            );
        });
    }) 

    $(document).on('change', 'input:file#add_attachment_button', function (e) {
        var purchase_request_id = $('#purchase_request_id').val();     
        if ( purchase_request_id == undefined || purchase_request_id < 0 ) {
            return;
        }

        let formData = new FormData();

        for(i = 0; i < this.files.length; i++) {
            formData.append('media[]', this.files[i]);
        }

        var url = `/purchase_requests/${purchase_request_id}/media`;

        axios.post(url,
            formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
        ).then( function (response) {
            if ( response.status == 200 ) { 
                response.data.forEach( function (media) {
                    console.log(media);
                    appendMedia($('#attachment_container'), media);
                });
            }
        })
        .catch( function ( error ){           
            if ( error.response.status == 422 ) {
                Swal.fire(
                    'Error',
                    error.response.data.message,
                    'error'
                );
            } else {
                Swal.fire(
                    'Error',
                    error.message,
                    'error'
                );
            }           
        });
    });

    $(document).on('click', '.btn-remove-table-item', function (e) {        
        $(this).closest('tr').remove();       
    });

    $(document).ready(function(){
        $("#btnAddItem").on('click',function(e){
            e.preventDefault();
            rowCount= $("#table_body tr").length+1;
              var html = `<tr class="text-center">
            <td><input type="text" name="purchase_request_details[${rowCount - 1}][item_code]" class="form-control"></td>
            <td><textarea rows="3" class="form-control" name="purchase_request_details[${rowCount - 1}][description]"></textarea></td>
            <td><input type="text" name="purchase_request_details[${rowCount - 1}][unit_of_measurement]" class="form-control"></td>
            <td><input type="number" name="purchase_request_details[${rowCount - 1}][quantity]" step="any" class="form-control"></td>
            <td><input type="text" name="purchase_request_details[${rowCount - 1}][expected_arrival_date]" class="form-control datepicker" ></td>
            <td><textarea rows="3" class="form-control" name="purchase_request_details[${rowCount - 1}][purpose]"></textarea></td>
            <td><input type="text" name="purchase_request_details[${rowCount - 1}][staff_id]" class="form-control"></td>
            <td><button class="btn btn-sm btn-danger btn-remove-table-item"><i class="fa fa-trash"></i></button></td></tr>`;
            $("#table_item").append(html);
            $('.datepicker').datepicker({format: "{{ config('app.js_date_format') }}", orientation : "bottom", autoclose : true});
        });   
    });
</script>
@endpush