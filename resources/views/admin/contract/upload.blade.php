@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.contracts.upload',['id'=>$contract->id]) }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data">
    @csrf 
        <div class="row justify-content-center">      
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        Contract : <strong>{{ $contract->unit->code }} - {{ $contract->customer1_name }}</strong>                   
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
                        <div class="row">
                            <div class="col input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="signed_contract_file_url">Select Contract PDF file:</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="signed_contract_file_url" class="signed_contract_file_url" id="inputGroupFile01"/>
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="text-muted font-italic">Please select the contract file which all parties have signed and scanned as PDF file format.</p>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">                    
                        <div class="row">
                            @role('contract_controller')
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{ __("Upload") }}</button>
                            </div>
                            @endrole
                            <div class="col">
                                <a href="{{ route('admin.contracts.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Contract Page") }}</a>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
