<!DOCTYPE html>
<html lang="km">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Purchase Requisition - {{ $purchase_request->code }}</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/contract_print_v2.css') }}"> 
</head> 
<body style="font-family: KhmerOScontent !important;">  
<div class="container bg-white">
  <div class="row">
    <div class="col-md-12">
      <img src="{{ asset('img/logo/pruchase_request_logo.png') }}" width="250px" style="position: absolute;top: 20px;">
      <h1 class="text-center py-5">Purchase Requisition</h1>
    </div>  
  </div>
  <div class="row">
    <div class="col-md-6">
      <table class="table table-sm table-bordered">
        <tr>
          <th colspan="4">General Information</th>
        </tr>
        <tr>          
          <td width="90px">Code:</td>
          <th>{{ $purchase_request->code }}</th>
          <td>Date:</td>
           <th>{{ $purchase_request->created_at->toSystemDateString() }}</th>
        </tr>
        <tr>
          <td>Project:</td>
          <th colspan="3">{{ $purchase_request->purchaseRequestProject->name }}</th>
        </tr>
        <tr>
          <td>Department:</td>
          <th colspan="3">{{ $purchase_request->department->name }}</th>
        </tr>
        <tr>
          <td>MRP No:</td>
          <th colspan="3">{{ $purchase_request->mrp_no }}</th>
        </tr>
      </table>
    </div>
    <div class="col-md-6">
      <table class="table table-sm table-bordered">
        <tr>
          <th colspan="2">Shipment Information</th>
        </tr>
        <tr>
          <td width="110px">Contact Name</td>
          <th>{{ $purchase_request->shipment_contact_name }}</th>
        </tr>
        <tr>
          <td>Phone Number:</td>
          <th>{{ $purchase_request->shipment_contact_number }}</th>
        </tr>
        <tr>
          <td>Address</td>
          <th>{{ $purchase_request->shipment_address_line1}} <br/> {{ $purchase_request->shipment_address_line2 }}</th>
        </tr>
      </table>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12">
      <table class="table table-sm table-bordered">
        <thead>
          <tr class="text-center">
            <th width="50px">No.</th>
            <th width="150px">Item Code</th>
            <th width="350px">Description</th>
            <th width="80px">UOM</th>
            <th width="80px">QTY</th>
            <th width="120px">Expected Arrival Date</th>
            <th width="200px">Purpose</th>
            <th width="200px">Staff ID</th>
          </tr>
        </thead>
        <tbody>
          @foreach($purchase_request->purchaseRequestDetails as $purchase_request_detail)
          <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">{{ $purchase_request_detail->item_code }}</td>
            <td>{{ $purchase_request_detail->description }}</td>
            <td class="text-center">{{ $purchase_request_detail->unit_of_measurement }}</td>
            <td class="text-center">{{ $purchase_request_detail->quantity }}</td>
            <td class="text-center">{{ $purchase_request_detail->expected_arrival_date->toSystemDateString() }}</td>
            <td>{{ $purchase_request_detail->purpose }}</td>
            <td>{{ $purchase_request_detail->staff_id }}</td>
          </tr>
          @endforeach   
          <tr>
            <td colspan="8"><strong>Remark:</strong> {{ $purchase_request->remark }}</td>
          </tr>
          <tr>
            <td colspan="8">
              <span><strong>** Note **</strong></span>
              <ul>
                <li>Budget < 100 USD requestor is able direct to purchase without procurement team.</li>
                <li>Budget > 101 USD requestor need to follow procurement procedure.</li>
              </ul>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-12">
      <span><strong>(For Cost Controller Only)</strong></span>
      <table class="table table-sm table-bordered">
        <tr>
          <td width="20px"><strong>Budget Relocated: </strong></td>
          <td colspan="2"></td>
        </tr>
        <tr>
          <td></td>
          <td width="40%">
            <span class="mr-5">OPEX</span>
            <span>CAPEX</span>
          </td>
          <td width="40%"></td>
        </tr>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table class="table table-bordered">
        <tr>
          <td width="25%">
            <span class="d-block text-center">Requested by</span>
            <div style="height:120px; width: 100%; padding:10px 0px;">
              <img src="{{ $purchase_request->createdBy->signature_image_url }}" height="100%" />
            </div>            
            <span class="d-block">Name: <strong>{{ $purchase_request->createdBy->name }}</strong></span>
            <span class="d-block">Date: {{ $purchase_request->created_at->toSystemDateString() }}</span>
          </td>
          @foreach( $purchase_request->approvals as $approval )
          <td width="25%">
            @if($approval->action == true)
            <span class="d-block text-center">{{ ucfirst(strtolower($approval->action_true)) }} by</span>  
            <div style="height:120px; width: 100%; padding:10px 0px;">
              <img src="{{ $approval->approver->signature_image_url }}" height="100%" />
            </div>       
            <span class="d-block">Name: <strong>{{ $approval->approver->name }}</strong></span>
            <span class="d-block">Date: {{ $approval->actioned_at->toSystemDateString() }}</span>
            @endif()
          </td>

          @endforeach  
        </tr>
      </table>
    </div>
  </div>
</div>
</body>
</html>