@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-3 d-none-sm d-sm-none d-none d-md-none d-lg-block">
            <div id="scrollspy-list" class="list-group sticky-top">
                <a class="list-group-item list-group-item-action" href="#customer-information">Customer Information</a>   
                <a class="list-group-item list-group-item-action" href="#unit-information">Unit Information:</a> 
                <a class="list-group-item list-group-item-action" href="#pricing-information">Pricing Information:</a> 
                <a class="list-group-item list-group-item-action" href="#payment-option">Payment Option</a>        
                <a class="list-group-item list-group-item-action" href="#agent-information">Agent Information</a>               
                <a class="list-group-item list-group-item-action" href="#attachment">Attachment</a>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    Contract : <strong>{{ $contract->unit->code }}</strong>                   
                </div>
                <form novalidate="novalidate" autocomplete="false">
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
                </div>
                <div class="card-footer">                    
                    <div class="row">
                        @role('contract_controller')
                        <div class="col">                           
                            <button type="submit" class="btn btn-primary">{{ __("Update") }}</button>
                        </div>
                        @endrole
                        <div class="col">
                            <a href="{{ route('admin.unit_contract_requests.index') }}" class="btn btn-secondary float-right">Back to Unit Contract Request List</a>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
