@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.companies.store') }}" novalidate="novalidate" autocomplete="false">
        @csrf        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{__("Company")}} : {{ __("Create New") }}</div>
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
                        {{-- Three Flags --}}
                        
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-khmer-tab" data-toggle="tab" href="#nav-khmer" role="tab" aria-controls="nav-khmer" aria-selected="true">Khmer <span class="flag-icon flag-icon-kh"></span></a>
                                <a class="nav-item nav-link" id="nav-english-tab" data-toggle="tab" href="#nav-english" role="tab" aria-controls="nav-english" aria-selected="false">English <span class="flag-icon flag-icon-us"></span></a>
                                <a class="nav-item nav-link" id="nav-chinese-tab" data-toggle="tab" href="#nav-chinese" role="tab" aria-controls="nav-chinese" aria-selected="false">Chinese <span class="flag-icon flag-icon-cn"></span></a>
                            </div>
                        </nav>


                        <div class="tab-content border border-top-0 px-3 pt-2 mb-3">
                            <div class="tab-pane fade show active" id="nav-khmer" role="tabpanel" aria-labelledby="nav-khmer-tab">
                                <div class="row">
                                    <div class="form-group col">
                                        <label for="name_km">{{ __('Name') }}: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name_km" id="name" value="{{ old('name_km') }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col">
                                        <label for="address_line1">{{ __('Address Line 1') }}:</label>
                                        <input type="text" class="form-control" name="address_line1" id="address_line1" value="{{ old('address_line1') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col">
                                        <label for="address_line2">{{ __('Address Line 2') }}:</label>
                                        <input type="text" class="form-control" name="address_line2" id="address_line2" value="{{ old('address_line2') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-english" role="tabpanel" aria-labelledby="nav-english-tab">              
                                <div class="row">
                                    <div class="form-group col">
                                        <label for="name_en">{{ __('Name') }}: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name_en" id="name_en" value="{{ old('name_en') }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col">
                                        <label for="address_line1_en">{{ __('Address Line 1') }}:</label>
                                        <input type="text" class="form-control" name="address_line1_en" id="address_line1_en" value="{{ old('address_line1_en') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col">
                                        <label for="address_line2_en">{{ __('Address Line 2') }}:</label>
                                        <input type="text" class="form-control" name="address_line2_en" id="address_line2_en" value="{{ old('address_line2_en') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-chinese" role="tabpanel" aria-labelledby="nav-chinese-tab">
                                <div class="row">
                                    <div class="form-group col">
                                        <label for="name_zh">{{ __('Name') }}: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name_zh" id="name_zh" value="{{ old('name_zh') }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col">
                                        <label for="address_line1_zh">{{ __('Address Line 1') }}:</label>
                                        <input type="text" class="form-control" name="address_line1_zh" id="address_line1_zh" value="{{ old('address_line1_zh') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col">
                                        <label for="address_line2_zh">{{ __('Address Line 2') }}:</label>
                                        <input type="text" class="form-control" name="address_line2_zh" id="address_line2_zh" value="{{ old('address_line2_zh') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Three Flags --}}

                        <div class="row">
                            <div class="form-group col-md">
                                <label for="contact_phone_number">{{ __("Contact Phone Number") }}:</label>
                                <input type="text" class="form-control" name="contact_phone_number" id="contact_phone_number" value="{{ old('contact_phone_number') }}">
                            </div>
                            <div class="form-group col-md">
                                <label for="email_address">{{ __("Email Address") }}:</label>
                                <input type="text" class="form-control" name="email_address" id="email_address" value="{{ old('email_address') }}">
                            </div>
                            <div class="form-group col-md">
                                <label for="website">{{ __("Website") }}:</label>
                                <input type="text" class="form-control" name="website" id="website" value="{{ old('website') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md">
                                <label for="tax_no">{{ __("Tax No") }}:</label>
                                <input type="text" class="form-control" name="tax_no" id="tax_no" value="{{ old('tax_no') }}">
                            </div>
                            <div class="form-group col-md">
                                <label for="tax_issued_date">{{ __("Issued Date") }}:</label>
                                <input type="text" class="form-control datepicker" name="tax_issued_date" id="tax_issued_date" value="{{ old('tax_issued_date') }}">
                            </div>
                        </div>
                        <div class="row">                           
                            <div class="form-group col-md">
                                <label for="commercial_license_no">{{ __("Commercial License No") }}:</label>
                                <input type="text" class="form-control" name="commercial_license_no" id="commercial_license_no" value="{{ old('commercial_license_no') }}">
                            </div>
                            <div class="form-group col-md">
                                <label for="commercial_license_issued_date">{{ __("Issued Date") }}:</label>
                                <input type="text" class="form-control datepicker" name="commercial_license_issued_date" id="commercial_license_issued_date" value="{{ old('commercial_license_issued_date') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg">
                                <label for="nav_company_code">{{ __("Dynamic NAV Company Code") }}:</label>
                                <input type="text" class="form-control" name="nav_company_code" id="nav_company_code" value="{{ old('nav_company_code') }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{__("Create New")}} {{ __("Company") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.companies.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Company List") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
