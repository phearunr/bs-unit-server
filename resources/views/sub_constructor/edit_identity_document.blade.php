@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <h4>Update Sub Constructor Identity Document</h4>
            <hr>
        </div>  
    </div>
    <div class="row">
        <div class="col-12"> 
            <div class="card">
                <div class="card-body">
                    @if ($errors->hasBag('update_sub_constructor_identity_document'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->update_sub_constructor_identity_document->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('update_sub_constructor_identity_document'))
                        <div class="alert alert-success" role="alert">
                            {{ session('update_sub_constructor_identity_document') }}
                        </div>
                    @endif 
                    <form method="POST" action="{{ route('sub_constructors.identity_documents.update', ['id' => $identity_document->model_id, 'identity_document_id' => $identity_document->id ]) }}" novalidate="novalidate" autocomplete="off" enctype="multipart/form-data" id="UpdateSubConstructorIdentityDocumentForm">    
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-3 col-md-3">Identity Document Type: <span class="text-danger">*</span></div>
                            <div class="col-3 col-md-3">Identity Document Code: <span class="text-danger">*</span></div>
                            <div class="col-2 col-md-2">Issue Date:</div>
                            <div class="col-2 col-md-2">Expiration Date:</div>
                            <div class="col-2 col-md-2">Image:</div>

                        </div>
                        <div class="form-row">
                            <div class="col-3 col-md-3">
                                <select class="form-control " name="type" id="identity_document">
                                    <option value="NATIONALITY_ID" {{ $identity_document->type == 'NATIONALITY_ID' ? 'selected' : '' }}>Nationality ID</option>
                                    <option value="PASSPORT" {{ $identity_document->type == 'PASSPORT' ? 'selected' : '' }}>Passport</option>
                                </select> 
                            </div>
                             <div class="col-3 col-md-3">
                                <input type="text" class="form-control" name="reference_no" value="{{ old('reference_no') ?? $identity_document->reference_no }}"> 
                            </div>
                            <div class="col-2 col-md-2">
                                <input type="text" name="issue_date" id="issue_date" class="form-control datepicker" value="{{ old('issue_date') ?? $identity_document->issue_date->toSystemDateString() }}"> 
                            </div>
                            <div class="col-2 col-md-2">
                                <input type="text" name="expiration_date" id="expiration_date" class="form-control datepicker" value="{{ old('expiration_date') ?? $identity_document->expiration_date->toSystemDateString() }}"> 
                            </div>
                            <div class="col-2 col-md-2">
                                <input type="file" name="attachment" id="attachment" class="d-none"/>
                                <label class="btn btn-md btn-block btn-primary" for="attachment">Attachment</label>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary btn-sm" form="UpdateSubConstructorIdentityDocumentForm" name="update" id="btnupdate">Update</button>
                        <a href="{{ URL::previous() }}" class="btn btn-success btn-sm float-right">Go Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
