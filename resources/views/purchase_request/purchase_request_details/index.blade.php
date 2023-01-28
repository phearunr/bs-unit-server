@extends('layouts.app')

@section('styles')
<style type="text/css">
.nav-small .nav-link {
    font-size: 0.75rem !important;
    padding-right: 8px;
}     
.flex-table {
    display: flex;    
    flex-direction: column;
    padding: 0.25rem 1rem;   
} 

.flex-table .title {
    width: 100%;
}

.flex-table .content {
    flex-grow: 1;
    border-bottom: 1px dashed #cacaca;
}

@media (min-width: 768px) { 
    .flex-table {
        flex-direction: row !important;
    }

    .flex-table .title {
        min-width: 180px;
        max-width: 180px;
    }
}
</style>

@endsection

@section('content')
<div class="container">
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
    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    {{ __('Filter')  }}
                    <span class="float-right" data-toggle="collapse" data-target="#filter-container" aria-controls="filter-container" aria-expanded="true">
                        <i class="fas fa-angle-up"></i>
                    </span>
                </div>
                <div id="filter-container" class="collapse show">                    
                    <div class="card-body ">                        
                        <form>      
                            <div class="form-group">
                                <label for="code">Search:</label>
                                <input type="hidden" name="staff_id" value="{{  Request::query('staff_id') }}">
                                <input type="text" name="search" class="form-control form-control-sm" id="code" placeholder="item code & UOM" value="{{ Request::query('code') }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm float-right mb-3">Show Result</button>
                        </form>
                    </div>                 
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-8">
            <div class="row">
                <div class="col">
                </div>
            </div>
            @foreach($purchase_request_details as $purchase_request_detail )            
            <div class="bg-white mb-2 py-2 border shadow-sm">
                <div class="flex-table">
                    <div class="title text-muted">PR No:</div>
                    <div class="content font-weight-bold"><a href="{{ route('purchase_requests.show', ['id'=> $purchase_request_detail->purchase_request_id]) }}">{{ $purchase_request_detail->purchaseRequest->code }}</a></div>
                </div>
                <div class="flex-table">
                    <div class="title text-muted">Staff ID:</div>
                    <div class="content font-weight-bold">{{  $purchase_request_detail->staff_id }}</div>
                </div>
                <div class="flex-table">
                    <div class="title text-muted">Item Code:</div>
                    <div class="content font-weight-bold">{{  $purchase_request_detail->item_code }}</div>
                </div>
                <div class="flex-table">
                    <div class="title text-muted">Expected Arrival Date:</div>
                    <div class="content font-weight-bold">{{  $purchase_request_detail->expected_arrival_date->toSystemDateString() }}</div>
                </div>
                <div class="flex-table">
                    <div class="title text-muted">Quantity:</div>
                    <div class="content font-weight-bold">{{ $purchase_request_detail->quantity }}</div>
                </div>
                <div class="flex-table">
                    <div class="title text-muted">UOM:</div>
                    <div class="content font-weight-bold">{{ $purchase_request_detail->unit_of_measurement }}</div>
                </div>
                <div class="flex-table">
                    <div class="title text-muted">Description:</div>
                    <div class="content font-weight-bold border-0">{{ $purchase_request_detail->description }}</div>
                </div>
            </div>
            @endforeach

            {{ $purchase_request_details ->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

</script>
@endpush