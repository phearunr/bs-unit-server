@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <h4>Sub Constructor Information</h4>
            <hr>
        </div>  
    </div>
    <div class="row">
        <div class="col-12"> 
            <div class="card">
                <div class="card-body" id="headingOne">
                    @if ($errors->hasBag('update_sub_constructor_profile_information'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->update_sub_constructor_profile_information->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('update_sub_constructor_profile_information'))
                        <div class="alert alert-success" role="alert">
                            {{ session('update_sub_constructor_profile_information') }}
                        </div>
                    @endif 
                    <form method="POST" action="{{ route('sub_constructors.personal_information.update', [ 'id' => $sub_constructor->id ]) }}" novalidate="novalidate" enctype="multipart/form-data" autocomplete="off" id="UpdatePersonalInformationForm">
                        @csrf     
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <h5 class="p-2 mb-0 bg-secondary text-white">Personal Information</h5>
                                <div class="d-flex py-3">
                                    <div style="width: 120px;">
                                        <img src="{{ $sub_constructor->avatar_url }}" width="100%" id="user_avatar" class="rounded-circle d-block">
                                        <div class="my-2 text-center">
                                            <input type="file" id="avatar" name="avatar" class="d-none"> 
                                            <label for="avatar" class="btn btn-primary btn-sm mb-0">Set User Image</label></div>
                                        </div>
                                    <div class="w-100 pl-3">
                                        <div class="form-group">
                                            <label for="name">Full Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter full name" value="{{ old('name') ?? $sub_constructor->name }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="join_date">Join Date: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control datepicker" name="join_date" id="join_date" value="{{ old('join_date') ?? $sub_constructor->join_date->toSystemDateString() }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Workers: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="worker" id="worker" placeholder="Enter number of worker" value="{{ old('worker') ?? $sub_constructor->worker }}" />
                                        </div>
                                         <button type="submit" form="UpdatePersonalInformationForm" class="btn btn-primary btn-sm float-right">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </form>

                    <div class="clearfix"></div>

                    <h5 class="bg-secondary mt-2 mb-0 p-2 text-white">
                        Contacts
                        <button type="button" data-toggle="collapse" data-target="#contactSection" aria-expanded="true" class="btn btn-link float-right">
                            <i class="fas fa-angle-down"></i>
                        </button>
                    </h5>
                    @if ($errors->hasBag('sub_constructor_contact'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->sub_constructor_contact->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('sub_constructor_contact'))
                        <div class="alert alert-success" role="alert">
                            {{ session('sub_constructor_contact') }}
                        </div>
                    @endif 
                    <div id="contactSection" class="collapse show"> 
                    <form method="POST" action="{{ route('sub_constructors.contacts.store', ['id' => $sub_constructor->id ]) }}" novalidate="novalidate" autocomplete="off" id="CreateSubConstructorContact">
                        @csrf
                        <div class="container bg-light py-2 mb-2">
                            <div class="row">
                                <div class="col-5 col-md-3">Contact Type: <span class="text-danger">*</span></div>
                                <div class="col-7 col-md-9">Contact Value: <span class="text-danger">*</span></div>
                            </div>
                            <div class="form-row">
                                <div class="col-5 col-md-3">
                                    <select class="form-control" name="type" id="type">
                                        <option value="MOBILE_PHONE_NUMBER">Mobile Phone Number</option>
                                        <option value="OFFICE_PHONE_NUMBER">Office Phone Number</option>
                                    </select> 
                                </div>
                                <div class="col-6 col-md-8">
                                    <input type="text" class="form-control" name="value" id="value" placeholder="Enter your contact"> 
                                </div>
                                <div class="col-1">
                                    <button type="submit" class="btn btn-block btn-primary" form="CreateSubConstructorContact" name="add" id="btnadd"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @foreach ($sub_constructor->contacts as $contact)
                    <div class="row">
                        <div class="col-5 col-md-3">
                            <span class="d-block border-bottom py-2">{{ $contact->display_type }}</span>
                        </div>
                        <div class="col-5 col-md-8">
                            <span class="d-block border-bottom font-weight-bold py-2">: {{ $contact->value }}</span>
                        </div>
                        <div class="col-2 col-md-1 mt-2">
                            <a class="btn btn-sm btn-success" href="{{ route('sub_constructors.contacts.edit', ['id' => $sub_constructor, 'contact_id' => $contact->id]) }}"><i class="fas fa-pencil-alt"></i></a>
                            <a class="btn btn-sm btn-danger" href="{{ route('sub_constructors.contacts.delete', ['id' => $sub_constructor, 'contact_id' => $contact->id]) }}"><i class="fas fa-times"></i></a>
                        </div> 
                    </div>
                    @endforeach
                    </div>
                    
                    <div class="clearfix"></div><br>

                    <h5 class="bg-secondary mt-2 mb-0 p-2 text-white">
                        Identity Document
                        <button type="button" data-toggle="collapse" data-target="#identityDocumentSector" aria-expanded="true" class="btn btn-link float-right">
                            <i class="fas fa-angle-down"></i>
                        </button>
                    </h5>
                    @if ($errors->hasBag('sub_constructor_identity_document'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->sub_constructor_identity_document->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('sub_constructor_identity_document'))
                        <div class="alert alert-success" role="alert">
                            {{ session('sub_constructor_identity_document') }}
                        </div>
                    @endif 
                    <div id="identityDocumentSector" class="collapse show">   
                        <div class="container bg-light py-2">
                             <form method="POST" action="{{ route('sub_constructors.identity_documents.store', ['id' => $sub_constructor->id ]) }}" novalidate="novalidate" autocomplete="off" enctype="multipart/form-data" id="CreateSubConstructorIdentityDocumentForm">
                                @csrf
                                <input type="hidden" id="identity_document_id" value="">
                                <div class="row">
                                    <div class="col-3 col-md-3">Identity Document Type: <span class="text-danger">*</span></div>
                                    <div class="col-2 col-md-2">Value: <span class="text-danger">*</span></div>
                                    <div class="col-2 col-md-2">Issue Date:</div>
                                    <div class="col-2 col-md-2">Expiration Date:</div>
                                    <div class="col-2 col-md-2">Media:</div>

                                </div>
                                <div class="form-row">
                                    <div class="col-3 col-md-3">
                                        <select class="form-control " name="type" id="identity_document">
                                            <option value="NATIONAL_ID">National ID</option>
                                            <option value="PASSPORT">Passport</option>
                                        </select> 
                                    </div>
                                    <div class="col-2 col-md-2">
                                        <input type="text" class="form-control" name="reference_no" id="reference_no" placeholder="Reference code"> 
                                    </div>
                                    <div class="col-2 col-md-2">
                                        <input type="text" name="issue_date" id="issue_date" class="form-control datepicker"> 
                                    </div>
                                    <div class="col-2 col-md-2">
                                        <input type="text" name="expiration_date" id="expiration_date" class="form-control datepicker"> 
                                    </div>
                                    <div class="col-2 col-md-2">
                                        <input type="file" name="attachment" id="attachment" class="d-none"/>
                                        <label class="btn btn-md btn-primary" for="attachment">Attachment</label>
                                    </div>
                                    <div class="col-1">
                                         <button type="submit" class="btn btn-block btn-primary" form="CreateSubConstructorIdentityDocumentForm" name="create" id="btncreate"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @foreach ($sub_constructor->identityDocuments as $identityDocument)
                        <div class="row">
                            <div class="col-3 col-md-3">
                                <span class="d-block border-bottom py-2">{{ ucwords(strtolower(str_replace('_', ' ', $identityDocument->type))) }}</span>
                            </div>
                            <div class="col-2 col-md-2">
                                <span class="d-block border-bottom font-weight-bold py-2">: {{ $identityDocument->reference_no }}</span>  
                            </div>
                            <div class="col-2 col-md-2">
                                <span class="d-block border-bottom font-weight-bold py-2">&nbsp;{{ $identityDocument->issue_date ? $identityDocument->issue_date->toSystemDateString() : '' }}</span>  
                            </div>
                            <div class="col-2 col-md-2">
                                <span class="d-block border-bottom font-weight-bold py-2">&nbsp;{{ $identityDocument->expiration_date ? $identityDocument->expiration_date->toSystemDateString() : '' }}</span>  
                            </div>
                            <div class="col-2 col-md-2">
                                @if($identityDocument->hasMedia())
                                <a href="{{ $identityDocument->getFirstMediaUrl() }}" target="_blank" class="d-block border-bottom py-2">View File</a>
                                @endif
                            </div>

                            <div class="col-1 col-md-1 mt-2">
                                <a class="btn btn-sm btn-success" href="{{ route('sub_constructors.identity_documents.edit', ['id' => $sub_constructor, 'identity_document_id' => $identityDocument->id]) }}"><i class="fas fa-pencil-alt"></i></a>
                                <a class="btn btn-sm btn-danger" href="{{ route('sub_constructors.identity_documents.delete', ['id' => $sub_constructor, 'identity_document_id' => $identityDocument->id]) }}"><i class="fas fa-times"></i></a>
                            </div>
                        </div>
                    @endforeach
                    </div>

                    <div class="clearfix"></div>

                    <h5 class="bg-secondary my-2 p-2 text-white">
                        Skill
                        <button type="button" data-toggle="collapse" data-target="#skillSection" aria-expanded="false" class="btn btn-link float-right">
                            <i class="fas fa-angle-down"></i>
                        </button>
                    </h5>

                    @if ($errors->hasBag('sub_constructor_skill'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->sub_constructor_skill->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            </div>
                    @endif
                    @if (session('sub_constructor_skill'))
                        <div class="alert alert-success" role="alert">
                            {{ session('sub_constructor_skill') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('sub_constructors.skills.update', ['id' => $sub_constructor->id]) }}" novalidate="novalidate" autocomplete="false" id="CreateSubConstructorSkillForm">
                        @csrf
                        @method('PUT')
                        <div id="skillSection" class="container collapse show mb-3">
                            <div class="row">
                                @php
                                    $sub_constructor_has_skills = $sub_constructor->skills->pluck('id')->toArray();                                 
                                @endphp
                                @foreach($sub_constructor_skills as $sub_constructor_skill)
                                <div class="col-md-4 form-check">
                                    <input class="form-check-input" type="checkbox" 
                                        name="skills[]" value="{{ $sub_constructor_skill->id }}" id="sub_constructor_skill-{{$sub_constructor_skill->id}}" 
                                        {{ in_array($sub_constructor_skill->id, $sub_constructor_has_skills) ? 'checked' : ''}}>
                                    <label class="form-check-label" for="defaultCheck1">
                                        {{ $sub_constructor_skill->name_km }} - ({{ $sub_constructor_skill->name }})
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <a href="{{ route('sub_constructors.index') }}" class="btn btn-success btn-sm">Go Back</a>
                        <button type="submit" form="CreateSubConstructorSkillForm" class="btn btn-primary btn-sm float-right">Update</button>
                    </form>
                </div>
            </div>
        </div> 
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready( function () {
        $('input[type="file"][name="avatar"]').change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#user_avatar').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);
            }
        });
    });
   
</script>

@endpush
