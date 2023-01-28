@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <h4>Update Sub Constructor Contact</h4>
            <hr>
        </div>  
    </div>
    <div class="row">
        <div class="col-12"> 
            <div class="card">
                <div class="card-body">
                    @if ($errors->hasBag('update_sub_constructor_contact'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->update_sub_constructor_contact->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('update_sub_constructor_contact'))
                        <div class="alert alert-success" role="alert">
                            {{ session('update_sub_constructor_contact') }}
                        </div>
                    @endif 
                    <form method="POST" action="{{ route('sub_constructors.contacts.update', ['id' => $contact->model_id, 'contact_id' => $contact->id ]) }}" novalidate="novalidate" autocomplete="off" id="UpdateSubConstructorContactForm">    
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-5 col-md-3">Contact Type:</div>
                            <div class="col-7 col-md-9">Value:</div>
                        </div>
                        <div class="form-row">
                            <div class="col-5 col-md-3">
                                <select class="form-control" name="type" id="type">
                                    <option value="MOBILE_PHONE_NUMBER" {{ $contact->type == 'MOBILE_PHONE_NUMBER' ? 'selected' : '' }}>Mobile Phone Number</option>
                                    <option value="OFFICE_PHONE_NUMBER" {{ $contact->type == 'OFFICE_PHONE_NUMBER' ? 'selected' : '' }}>Office Phone Number</option>
                                </select> 
                            </div>
                            <div class="col-7 col-md-9">
                                <input type="text" class="form-control" name="value" id="value" value="{{ old('value') ?? $contact->value }}"> 
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2" form="UpdateSubConstructorContactForm">Update</button>
                        <a href="{{ URL::previous() }}" class="btn btn-success mt-2 float-right">Go Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
