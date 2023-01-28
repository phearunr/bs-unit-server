@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.projects.update', [ 'id' => $project->id ]) }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data">
    @csrf        
    {{ method_field("PUT") }}
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __("Edit") }} {{__("Project")}} : <strong>{{ $project->name }}</strong></div>
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
                            <div class="form-group col">
                                <label for="company_id">{{ __('Company') }}: <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="company_id">
                                    @foreach($companies as $company) 
                                        <option value="{{ $company->id }}" {{ old("company_id") == $company->id ? 'selected' : $company->id )== ($project->company_id ? 'selected' : '' }})>{{ $company->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
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
                                <div class="row">
                                    <div class="form-group col">
                                        <label for="name">Name: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" id="name" 
                                           placeholder="បុរី ចតុមុខស៊ីធី" 
                                           value="{{ old('name') ?? $project->name }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address: </label>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="ភូមិអូរតាសេក ឃុំអូរឧកញ៉ាហេង ស្រុកព្រៃនប់ ខេត្តព្រះសីហនុ" value="{{ old('address') ?? $project->address }}">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-english" role="tabpanel" aria-labelledby="nav-english-tab">              
                                <div class="row">
                                    <div class="form-group col">
                                        <label for="name_en">Name: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name_en" id="name_en" 
                                           placeholder="Borey Chaktomuk City" 
                                           value="{{ old('name_en') ?? $project->name_en }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address_en">Address: </label>
                                    <input type="text" class="form-control" name="address_en" id="address_en" placeholder="Home, Street, Sangkat, Khan, City" value="{{ old('address_en') ?? $project->address_en }}">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-chinese" role="tabpanel" aria-labelledby="nav-chinese-tab">
                                <div class="row">
                                    <div class="form-group col">
                                        <label for="name_zh">Name: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name_zh" id="name_zh" 
                                           placeholder="鮑里查克圖木剋市" 
                                           value="{{ old('name_zh') ?? $project->name_zh }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address_zh">Address: </label>
                                    <input type="text" class="form-control" name="address_zh" id="address_zh" placeholder="家，街道，桑加，可汗，城市" value="{{ old('address_zh') ?? $project->address_zh }}">
                                </div>
                            </div>
                        </div>
                        {{-- End Three Flags --}}
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="short_code">Short Code: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="short_code" id="short_code" 
                                       placeholder="Eg. EAST-SHV" 
                                       value="{{ $project->short_code }}">
                            </div>  
                            <div class="form-group col">
                                <label for="sale_representative_id">Sale Representative: <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="sale_representative_id">
                                    @foreach($sale_representatives as $sale_representative) 
                                        <option value="{{ $sale_representative->id }}" {{ $project->sale_representative_id == $sale_representative->id ? 'selected' : '' }}>{{ $sale_representative->name }}</option>
                                    @endforeach
                                </select>                               
                            </div> 
                            <div class="form-group col">
                                <label for="bank_id">Bank Account: <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="bank_id">
                                    @foreach($banks as $bank) 
                                        <option value="{{ $bank->id }}" {{ $project->bank_id == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg">
                                <label for="nav_company_code">{{ __("Dynamic NAV Company Code") }}: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nav_company_code" id="nav_company_code"
                                       value="{{ $project->nav_company_code }}">
                            </div>
                        </div>                      
                        <div class="form-group form-check col">
                            <input type="checkbox" class="form-check-input" name="is_published" id="is_published" value="1" {{ $project->is_published ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_published">{{ __("Published") }}</label>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-lg">
                                <h5>Unit Types:</h5>                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">                            
                                <table class="table table-bordered" id="unit_type_table">
                                    <thead>
                                        <tr class='bg-grey'>
                                            <th>Name</th>
                                            <th width="100px">Short Code</th>
                                            <th width="150px">Payment Options</th>
                                            <th width="150px">Contract Template</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach( $unit_types as $unit_type )
                                        <tr>
                                            <td scope="row">
                                                <a href="{{ route('admin.unit_types.edit',['id'=>$unit_type->id]) }}" target="_blank"><strong>{{ $unit_type->name }}</strong></a>
                                            </td>
                                            <td>{{ $unit_type->short_code }}</td>
                                            <td>
                                                <a href="{{ route('admin.payment_options.index', ['unit_type' => $unit_type->id]) }}">
                                                    <strong>{{ $count = $unit_type->payment_options_count }} {{ str_plural('Options',$count) }}</strong> 
                                                </a>
                                            </td>
                                            <td>
                                                @include('contract_template.partials.preview_dropdown', ['unit_type' => $unit_type])
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{ __("Update") }} {{ __("Project") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Project") }} {{__("List")}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{ __('Logo')  }}
                        <button type="button" class="btn btn-link float-right" data-toggle="collapse" data-target="#logo-body" aria-controls="logo-body" aria-expanded="true">
                            <i class="fas fa-angle-up"></i>
                        </button>
                    </div>
                    <div id="logo-body" class="collapse show" aria-labelledby="{{ __('Logo') }}">
                        <div class="card-body">                            
                            @if( $project->logo_url )
                            <figure class="figure border" >
                                <a href="{{ $project->logo_url }}" target="_blank">
                                    <img src="{{ $project->logo_url }}" class="mx-auto d-block">
                                </a>
                            </figure>
                            @endif
                            <div class="form-row">
                                <div class="col-lg">                                  
                                    <input type="file" class="form-control-file" name="logo_url" id="logo_url" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        {{ __('Feature Image')  }}
                        <button type="button" class="btn btn-link float-right" data-toggle="collapse" data-target="#feature-image-body" aria-controls="feature-image-body" aria-expanded="true">
                            <i class="fas fa-angle-up"></i>
                        </button>
                    </div>
                    <div id="feature-image-body" class="collapse show" aria-labelledby="{{ __('Feature Image') }}">
                        <div class="card-body">                            
                            @if( $project->feature_image_url )
                            <figure class="figure border" >
                                <a href="{{ $project->feature_image_url }}" target="_blank">
                                    <img src="{{ $project->feature_image_url }}" class="mx-auto img-fluid d-block">
                                </a>
                            </figure>
                            @endif
                            <div class="form-row">
                                <div class="col-lg">                                  
                                    <input type="file" class="form-control-file" name="feature_image_url" id="feature_image_url" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        {{ __('Master Plan')  }}
                        <button type="button" class="btn btn-link float-right" data-toggle="collapse" data-target="#master-plan-body" aria-controls="master-plan-body" aria-expanded="true">
                            <i class="fas fa-angle-up"></i>
                        </button>
                    </div>
                    <div id="master-plan-body" class="collapse show" aria-labelledby="{{ __('Master Plan') }}">
                        <div class="card-body">
                            <div class="form-row">
                                @if( $project->master_plan_url )
                                <div class="col-lg-12 mb-2 d-flex">
                                    <a href="{{ $project->master_plan_url }}" class="mr-auto"  target="_blank">{{ __('Click here to view') }}</a>
                                    <button class="btn btn-danger btn-sm master-plan-delete-btn" data-id="{{ $project->id }}"> 
                                        <i class="fas fa-trash-alt" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remove"></i>
                                    </button>
                                </div>
                                @endif
                                <div class="col-lg-12">                                  
                                    <input type="file" class="form-control-file" name="master_plan_url" id="master_plan_url" />
                                </div>
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
    $(document).on('click', '.master-plan-delete-btn', function (e) {
        e.preventDefault();
        var project_id = $(this).data('id');      
        axios.delete(`/admin/projects/${project_id}/media`, {
            'media_type' : 'master_plan_url'
        })
        .then( function (response) {
            if ( response.status == 200 ) { 
                location.reload();
            }
        })
        .catch( function ( error ){
            if ( error.response.status == 422 ) {
                Swal.fire(
                    'Error',
                    error.response.data.message,
                    'error'
                );
            } else {
                Swal.fire(
                    'Error',
                    error.message,
                    'error'
                );
            }
        });
    });   
</script>
@endpush
