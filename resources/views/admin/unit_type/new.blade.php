@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.unit_types.store') }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data">
    @csrf        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{__("Unit Type")}} : {{ __("Create New") }}</div>
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
                            <div class="col-lg form-group">
                                <label for="project_id">Project <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="project_id" id="project_id">
                                    @foreach ( $projects as $project )
                                        <option value="{{ $project->id }}" {{ $project->id == old('project_id') ? "selected" : "" }}>{{ $project->name_en }}</option>
                                    @endforeach
                                </select>                          
                            </div>  
                            <div class="col-lg form-group">
                                <label for="name">Name: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" 
                                       placeholder="House, Flat, Condo..." 
                                       value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="form-group">
                                    <label for="short_code">Short Code: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="short_code" id="short_code" 
                                           placeholder="code for the unit type" 
                                           value="{{ old('short_code') }}">
                                </div> 
                            </div>
                            <div class="col-lg">
                                <div class="form-group">
                                    <label for="contract_template_id">Contract Template: <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="contract_template_id" id="contract_template_id">  
                                        @foreach ( $contract_templates as $contract_template )
                                        <option value="{{ $contract_template->id }}" {{ $contract_template->id == old('contract_template_id') ? "selected" : "" }}>{{ $contract_template->name }}</option>
                                        @endforeach     
                                    </select>                             
                                </div> 
                            </div>
                        </div>                                               
                        <div class="form-group form-check col-lg">
                            <input type="checkbox" class="form-check-input" name="is_contractable" id="is_contractable" value="1" {{ old('is_contractable') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_contractable">{{ __('Contractable') }}</label>
                        </div>
                         <div class="row">
                            <div class="col-lg form-group">
                                <label for="annual_management_fee">Annual Management Fee</label>
                                <input type="number" min="0" name="annual_management_fee" class="form-control"  
                                    value="{{ old('annual_management_fee') ? old('annual_management_fee') : '0' }}"/>
                            </div>
                            <div class="col-lg form-group">
                                <label for="contract_transfer_fee">Contract Transfer Fee</label>
                                <input type="number" min="0" name="contract_transfer_fee" class="form-control" 
                                    value="{{ old('contract_transfer_fee') ? old('contract_transfer_fee') : '0'}}" />
                            </div>
                            <div class="col-lg form-group">
                                <label for="management_fee_per_square">Mgt. Fee per Square (Condo)</label>
                                <input type="number" min="0" name="management_fee_per_square" class="form-control" 
                                    value="{{ old('management_fee_per_square') ? old('management_fee_per_square') : '0' }}"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="deadline">Deadline</label>
                                <input type="number" min="0" name="deadline" class="form-control"
                                    value="{{ old('deadline') ? old('deadline') : '0' }}"/>
                            </div>
                            <div class="col-lg form-group">
                                <label for="extended_deadline">Extended Deadline</label>
                                <input type="number" min="0" name="extended_deadline" class="form-control"
                                    value="{{ old('extended_deadline') ? old('extended_deadline') : '0' }}"/>
                            </div>
                        </div>                            
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Payment Option Image: <span class="text-danger">*</span></label>
                            <input type="file" name="payment_option_image" class="form-control-file" id="exampleFormControlFile1">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile2">Feature Image: </label>
                            <input type="file" name="feature_image_url" class="form-control-file" id="exampleFormControlFile2">
                        </div>
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
                                <div class="form-group">
                                    <label for="title_clause_kh">Title Clause:</label>
                                    <textarea class="form-control" name="title_clause_kh" id="title_clause_kh" rows="4">{{ old('title_clause_kh') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="management_service_kh">Management Service Clause:</label>
                                    <textarea class="form-control" name="management_service_kh" id="management_service_kh" rows="4">{{ old('management_service_kh') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="equipment_text">Equipment Clause:</label>
                                    <textarea class="form-control" name="equipment_text" id="equipment_text" rows="10">{{ old("equipment_text") }}</textarea>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-english" role="tabpanel" aria-labelledby="nav-english-tab">
                                <div class="form-group">
                                    <label for="title_clause_en">Title Clause:</label>
                                    <textarea class="form-control" name="title_clause_en" id="title_clause_en" rows="4">{{ old('title_clause_en') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="management_service_en">Management Service Clause:</label>
                                    <textarea class="form-control" name="management_service_en" id="management_service_en" rows="4">{{ old('management_service_en') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="equipment_text_en">Equipment Clause:</label>
                                    <textarea class="form-control" name="equipment_text_en" id="equipment_text_en" rows="10">{{ old("equipment_text_en") }}</textarea>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-chinese" role="tabpanel" aria-labelledby="nav-chinese-tab">
                                <div class="form-group">
                                    <label for="title_clause_zh">Title Clause:</label>
                                    <textarea class="form-control" name="title_clause_zh" id="title_clause_zh" rows="4">{{ old('title_clause_zh') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="management_service_zh">Management Service Clause:</label>
                                    <textarea class="form-control" name="management_service_zh" id="management_service_zh" rows="4">{{ old('management_service_zh') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="equipment_text_zh">Equipment Clause:</label>
                                    <textarea class="form-control" name="equipment_text_zh" id="equipment_text_zh" rows="10">{{ old("equipment_text_zh") }}</textarea>
                                </div>
                            </div>
                        </div>
                        {{-- End Three Flags --}}                
                     </div>   
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{__("Create New")}} {{ __("Unit Type") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.unit_types.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Unit Type") }} {{__("List")}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push("scripts")
<script type="text/javascript">
    $(document).ready(function (){
        $('.select2').select2({ theme:"bootstrap4" });
        $('#equipment_text').summernote({
            height: 300,
        });
        $('#equipment_text_en').summernote({
            height: 300,
        });
        $('#equipment_text_zh').summernote({
            height: 300,
        });
    });
</script>
@endpush
