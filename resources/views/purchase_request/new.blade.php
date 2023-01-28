@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h4>New Purchase Request</h4>
            <hr>
        </div>  
    </div>    
       
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
    

    <form method="POST" action="{{ route('purchase_requests.store') }}" enctype="multipart/form-data" novalidate="novalidate" autocomplete="false">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                      
                            <div class="form-group">
                                <label for="requested_date">Request Date:</label>
                                <input type="text" class="form-control" placeholder="The date will be generate when you submit the request" readonly="" >
                            </div>
                            <div class="form-group">
                                <label for="purchase_request_project_id">Project <span class="text-danger">*</span>:</label>
                                <select class="form-control" id="purchase_request_project_id" name="purchase_request_project_id">
                                    @foreach($purchase_request_projects as $purchase_request_project)
                                    <option value="{{ $purchase_request_project->id }}" {{ (old('purchase_request_project_id') == $purchase_request_project->id) ? 'selected' : '' }}>{{ $purchase_request_project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="department_id">Department <span class="text-danger">*</span>:</label>
                                <select class="form-control" id="department_id" name="department_id">
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ (old('department_id') == $department->id) ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group'">
                                <label for="mrp_no">MRP No.</label>
                                <input type="text" name="mrp_no" id="mrp_no" class="form-control" value="{{ old('mrp_no') }}">
                            </div>                    
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shipment_contact_name">Shipment Contact Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="shipment_contact_name" id="shipment_contact_name" value="{{ old('shipment_contact_name') }}" />
                            </div>
                            <div class="form-group">
                                <label for="shipment_contact_number">Shipment Contact Number <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control" name="shipment_contact_number" id="shipment_contact_number" value="{{ old('shipment_contact_number') }}" />
                            </div>
                            <div class="form-group">
                                <label for="shipment_address_line1">Shipment Address Line 1 <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control" name="shipment_address_line1" id="shipment_address_line1" value="{{ old('shipment_address_line1') }}"/>
                            </div>
                            <div class="form-group'">
                                <label for="shipment_address_line2">Shipment Address Line 2:</label>
                                <input type="text" class="form-control" name="shipment_address_line2" id="shipment_address_line2" value="{{ old('shipment_address_line2') }}" />
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mb-3">
            <table class="table table-bordered bg-white mb-0 mt-3" id="table_item">
                <thead>
                    <tr class="text-center">                 
                        <th width="170px">{{ __('Item code') }}</th>
                        <th width="">{{ __('Description') }}</th>
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
                    @if( old('purchase_request_details') )
                        @foreach( old('purchase_request_details') as $key => $value )
                            <tr class="text-center" >                               
                                <td><input type="text" name="purchase_request_details[{{$key}}][item_code]" class="form-control" value="{{ $value['item_code'] }}"></td>
                                <td>
                                    <textarea rows="3" name="purchase_request_details[{{$key}}][description]" class="form-control">
                                        {{ $value['description'] }}
                                    </textarea>
                                </td>
                                <td><input type="text" name="purchase_request_details[{{$key}}][unit_of_measurement]" class="form-control" value="{{ $value['unit_of_measurement'] }}"></td>
                                <td><input type="number" name="purchase_request_details[{{$key}}][quantity]" class="form-control" step="any" value="{{ $value['quantity'] }}"></td>
                                <td><input type="text" name="purchase_request_details[{{$key}}][expected_arrival_date]" class="form-control datepicker" value="{{ $value['expected_arrival_date'] }}"></td>
                                <td><textarea rows="3" name="purchase_request_details[{{$key}}][purpose]" class="form-control">{{ $value['purpose'] }}</textarea></td>
                                <td><input type="text" name="purchase_request_details[{{$key}}][staff_id]" class="form-control" value="{{ $value['staff_id'] }}"></td>
                                <td><button class="btn btn-sm btn-danger btn-remove-table-item"><i class="fa fa-trash"></i></button></td>
                            </tr>
                        @endforeach
                    @else
                    <tr class="text-center" >                       
                        <td><input type="text" name="purchase_request_details[0][item_code]" class="form-control" ></td>
                        <td>
                            <textarea rows="3" class="form-control" name="purchase_request_details[0][description]"></textarea>
                        </td>
                        <td><input type="text" name="purchase_request_details[0][unit_of_measurement]" class="form-control"></td>
                        <td><input type="number" name="purchase_request_details[0][quantity]" step="any" class="form-control"></td>
                        <td><input type="text" name="purchase_request_details[0][expected_arrival_date]" class="form-control datepicker"></td>
                        <td><textarea rows="3" class="form-control" name="purchase_request_details[0][purpose]"></textarea></td>
                        <td><input type="text" name="purchase_request_details[0][staff_id]" class="form-control"></td>
                        <td><button class="btn btn-sm btn-danger btn-remove-table-item"><i class="fa fa-trash"></i></button></td>
                    </tr>
                    @endif
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
                    </div>
                    <input type="file" name="attachments[]" class="d-block my-2">
                    <input type="file" name="attachments[]" class="d-block my-2">
                    <input type="file" name="attachments[]" class="d-block my-2">
                    <input type="file" name="attachments[]" class="d-block my-2">
                    <input type="file" name="attachments[]" class="d-block my-2">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group">
                        <label for="remark">Remark <span class="text-danger">*</span>:</label>
                        <textarea class="form-control" name="remark" id="remark" rows="3">{{ old('remark') }}</textarea>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary text-right">Submit</button>
        </div>
    </div>
    </form>
</div>
@endsection

@push('scripts')

<script type="text/javascript"> 
   $(document).ready(function() {
        var selected_files = [];
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
        
        $(document).on('click', '.btn-remove-table-item', function (e) {        
            $(this).closest('tr').remove();       
        });
   });   
</script>
@endpush

