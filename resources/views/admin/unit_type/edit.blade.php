@extends('layouts.app')

@section('styles')
<style type="text/css">
.inputfile {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
}

.inputfile + label {
    max-width: 80%;
    font-size: 0.8rem;
    /* 20px */
    font-weight: 700;
    text-overflow: ellipsis;
    white-space: nowrap;
    cursor: pointer;
    display: inline-block;
    overflow: hidden;
    padding: 0.625rem 1.25rem;
    margin-bottom: 0;
    /* 10px 20px */
}

.no-js .inputfile + label {
    display: none;
}

.inputfile:focus + label,
.inputfile.has-focus + label {
    outline: 1px dotted #000;
    outline: -webkit-focus-ring-color auto 5px;
}

.inputfile + label * {
    /* pointer-events: none; */
    /* in case of FastClick lib use */
}

.inputfile + label svg {
    width: 1em;
    height: 1em;
    vertical-align: middle;
    fill: currentColor;
    margin-top: -0.25em;
    /* 4px */
    margin-right: 0.25em;
    /* 4px */
}


/* style 1 */

.inputfile-1 + label {
    color: #FFF;
    background-color: #3490dc;
}

.inputfile-1:focus + label,
.inputfile-1.has-focus + label,
.inputfile-1 + label:hover {
    background-color: #0069D8;
}
</style>
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.unit_types.update', [ 'id' => $unit_type->id ]) }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data" class="prevent-enter">
    @csrf        
    {{ method_field("PUT") }}
    <input type="hidden" id="unit_type_id" value="{{ $unit_type->id }}">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __("Edit") }} {{__("Unit Type")}} : <strong>{{ $unit_type->name }}</strong></div>
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
                                        <option value="{{ $project->id }}" {{ $project->id == $unit_type->project_id ? "selected" : "" }}>{{ $project->name_en }}</option>
                                    @endforeach
                                </select>               
                            </div>
                            <div class="col-lg form-group">
                                <label for="name">Name: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" 
                                       placeholder="House, Land, Condo ..." 
                                       value="{{ $unit_type->name }}">
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="col-lg">
                                <div class="form-group">
                                    <label for="short_code">Short Code: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="short_code" id="short_code" 
                                           placeholder="code for the unit type" 
                                           value="{{ $unit_type->short_code }}">
                                </div>   
                            </div>
                            <div class="col-lg">
                                <label for="contract_template_id">Contract Template <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="contract_template_id" id="contract_template_id">
                                    @foreach ( $contract_templates as $contract_template )
                                        <option value="{{ $contract_template->id }}" {{ $contract_template->id == $unit_type->contract_template_id ? "selected" : "" }}>{{ $contract_template->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                                          
                        <div class="form-group form-check col-lg">
                            <input type="checkbox" class="form-check-input" name="is_contractable" id="is_contractable" value="1" {{ $unit_type->is_contractable ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_contractable">{{ __('Contractable') }}</label>
                        </div>
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="annual_management_fee">Annual Management Fee</label>
                                <input type="number" min="0" name="annual_management_fee" class="form-control"  
                                    value="{{ $unit_type->annual_management_fee }}"/>
                            </div>
                            <div class="col-lg form-group">
                                <label for="contract_transfer_fee">Contract Transfer Fee</label>
                                <input type="number" min="0" name="contract_transfer_fee" class="form-control" 
                                    value="{{ $unit_type->contract_transfer_fee }}" />
                            </div>
                            <div class="col-lg form-group">
                                <label for="management_fee_per_square">Mgt. Fee per Square (Condo)</label>
                                <input type="number" min="0" name="management_fee_per_square" class="form-control" 
                                    value="{{ $unit_type->management_fee_per_square }}"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="deadline">Deadline</label>
                                <input type="number" min="0" name="deadline" class="form-control"
                                    value="{{ $unit_type->deadline }}"/>
                            </div>
                            <div class="col-lg form-group">
                                <label for="extended_deadline">Extended Deadline</label>
                                <input type="number" min="0" name="extended_deadline" class="form-control"
                                    value="{{ $unit_type->extended_deadline }}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="payment_option_image">Payment Option Image:</label>
                            <input type="file" name="payment_option_image" class="form-control-file" id="payment_option_image">
                            <small id="emailHelp" class="form-text text-muted">Click the choose file to upload new image if you wan to change the existing one.</small>
                        </div>  
                        @if( $unit_type->payment_option_image_url )
                        <figure class="figure border">
                            <a href="{{ $unit_type->payment_option_image_url }}" target="_blank">
                                <img src="{{ $unit_type->payment_option_image_url }}" class="figure-img img-fluid rounded">
                            </a>                            
                        </figure>  
                        @endif

                        <div class="form-group">
                            <label for="feature_image_url">{{ __("Feature Image") }}:</label>
                            <input type="file" name="feature_image_url" class="form-control-file" id="feature_image_url">
                            <small id="emailHelp" class="form-text text-muted">Click the choose file to upload new image if you wan to change the existing one.</small>
                        </div>  
                        @if( $unit_type->getOriginal('feature_image_url') )
                        <figure class="figure border">
                            <a href="{{ $unit_type->feature_image_url }}" target="_blank">
                                <img src="{{ $unit_type->feature_image_url }}" class="figure-img img-fluid rounded">
                            </a>                            
                        </figure>  
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
                                <div class="form-group">
                                    <label for="title_clause_kh">Title Clause:</label>
                                    <textarea class="form-control" name="title_clause_kh" id="title_clause_kh" rows="4">{{ old('title_clause_kh') ?? $unit_type->title_clause_kh }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="management_service_kh">Management Service Clause:</label>
                                    <textarea class="form-control" name="management_service_kh" id="management_service_kh" rows="4">{{ old('management_service_kh') ?? $unit_type->management_service_kh }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="equipment_text">Equipment Clause:</label>
                                    <textarea class="form-control" name="equipment_text" id="equipment_text" rows="10">{{ old("equipment_text") ?? $unit_type->equipment_text }}</textarea>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-english" role="tabpanel" aria-labelledby="nav-english-tab">
                                <div class="form-group">
                                    <label for="title_clause_en">Title Clause:</label>
                                    <textarea class="form-control" name="title_clause_en" id="title_clause_en" rows="4">{{ old('title_clause_en') ?? $unit_type->title_clause_en }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="management_service_en">Management Service Clause:</label>
                                    <textarea class="form-control" name="management_service_en" id="management_service_en" rows="4">{{ old('management_service_en') ?? $unit_type->management_service_en }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="equipment_text_en">Equipment Clause:</label>
                                    <textarea class="form-control" name="equipment_text_en" id="equipment_text_en" rows="10">{{ old("equipment_text_en") ?? $unit_type->equipment_text_en }}</textarea>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-chinese" role="tabpanel" aria-labelledby="nav-chinese-tab">
                                <div class="form-group">
                                    <label for="title_clause_zh">Title Clause:</label>
                                    <textarea class="form-control" name="title_clause_zh" id="title_clause_zh" rows="4">{{ old('title_clause_zh') ?? $unit_type->title_clause_zh }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="management_service_zh">Management Service Clause:</label>
                                    <textarea class="form-control" name="management_service_zh" id="management_service_zh" rows="4">{{ old('management_service_zh') ?? $unit_type->management_service_zh }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="equipment_text_zh">Equipment Clause:</label>
                                    <textarea class="form-control" name="equipment_text_zh" id="equipment_text_zh" rows="10">{{ old("equipment_text_zh") ?? $unit_type->equipment_text_zh }}</textarea>
                                </div>
                            </div>
                        </div>
                        {{-- End Three Flags --}}
                    </div>
                    
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{ __("Update") }} {{ __("Unit Type") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.unit_types.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Unit Type") }} {{__("List")}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{ __('Floor Plan')  }}
                        <button type="button" class="btn btn-link float-right" data-toggle="collapse" data-target="#floor-plan-body" aria-controls="floor-plan-body" aria-expanded="true">
                            <i class="fas fa-angle-up"></i>
                        </button>
                    </div>
                    <div id="floor-plan-body" class="collapse show" aria-labelledby="{{ __('Floor Plan') }}">
                        <div class="card-body">
                            <div id="floor_plan_container">
                            @foreach($unit_type->getMedia('FLOOR_PLAN') as $media)
                            <figure class="figure border position-relative">
                                <a href="{{ $media->getFullUrl() }}" target="_blank">
                                    <img src="{{ $media->getFullUrl('thumb') }}" class="img-fluid">
                                </a>
                                <button class="btn btn-danger btn-xs thumbnial-delete-btn" data-id="{{ $media->id }}"> 
                                    <i class="fas fa-trash-alt" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remove"></i>
                                </button>
                            </figure>
                            @endforeach
                            </div>
                            <div class="row">
                                <div class="col">
                                    <section class="footer">
                                        <input type="file" name="media[FLOOR_PLAN]" id="floor-plan-upload-button" class="inputfile inputfile-1 media-upload-button" multiple data-container="floor_plan_container" data-collection="FLOOR_PLAN"/>
                                        <label for="floor-plan-upload-button">{{ __('Add Floor Plan') }}</label>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        {{ __('Interior')  }}
                        <button type="button" class="btn btn-link float-right" data-toggle="collapse" data-target="#interior-body" aria-controls="floor-plan-body" aria-expanded="true">
                            <i class="fas fa-angle-up"></i>
                        </button>
                    </div>
                    <div id="interior-body" class="collapse show" aria-labelledby="{{ __('Floor Plan') }}">
                        <div class="card-body">
                            <div id="interior_container">
                            @foreach($unit_type->getMedia('INTERIOR') as $media)
                            <figure class="figure border position-relative">
                                <a href="{{ $media->getFullUrl() }}" target="_blank">
                                    <img src="{{ $media->getFullUrl('thumb') }}" class="img-fluid">
                                </a>
                                <button class="btn btn-danger btn-xs thumbnial-delete-btn" data-id="{{ $media->id }}"> 
                                    <i class="fas fa-trash-alt" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remove"></i>
                                </button>
                            </figure>
                            @endforeach
                            </div>
                            <div class="row">
                                <div class="col">
                                    <section class="footer">
                                        <input type="file" name="media[INTERIOR]" id="interior-upload-button" class="inputfile inputfile-1 media-upload-button" multiple data-container="interior_container" data-collection="INTERIOR"/>
                                        <label for="interior-upload-button">{{ __('Add Interior') }}</label>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        {{ __('Exterior')  }}
                        <button type="button" class="btn btn-link float-right" data-toggle="collapse" data-target="#exterior-body" aria-controls="floor-plan-body" aria-expanded="true">
                            <i class="fas fa-angle-up"></i>
                        </button>
                    </div>
                    <div id="exterior-body" class="collapse show" aria-labelledby="{{ __('Exterior') }}">
                        <div class="card-body">
                            <div id="exterior_container">
                            @foreach($unit_type->getMedia('EXTERIOR') as $media)
                            <figure class="figure border position-relative">
                                <a href="{{ $media->getFullUrl() }}" target="_blank">
                                    <img src="{{ $media->getFullUrl('thumb') }}" class="img-fluid">
                                </a>
                                <button class="btn btn-danger btn-xs thumbnial-delete-btn" data-id="{{ $media->id }}"> 
                                    <i class="fas fa-trash-alt" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remove"></i>
                                </button>
                            </figure>
                            @endforeach
                            </div>
                            <div class="row">
                                <div class="col">
                                    <section class="footer">
                                        <input type="file" name="media[EXTERIOR]" id="exterior-upload-button" class="inputfile inputfile-1 media-upload-button" multiple data-container="exterior_container" data-collection="EXTERIOR"/>
                                        <label for="exterior-upload-button">{{ __('Add Exterior') }}</label>
                                    </section>
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
    function appendMedia(parent_ele, media) {
        var html = `<figure class="figure border position-relative">
                                <a href="${media.url}" target="_blank">
                                    <img src="${media.url}" class="img-fluid">
                                </a>
                                <button class="btn btn-danger btn-xs thumbnial-delete-btn" data-id="${media.id}"> 
                                    <i class="fas fa-trash-alt" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remove"></i>
                                </button>
                            </figure>`;
        parent_ele.append(html);
    }

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

    $(document).on('change', 'input:file.media-upload-button', function (e) {
     
        var unit_type_id = $('#unit_type_id').val();

        if ( unit_type_id == undefined || unit_type_id < 0 ) {
            return;
        }


        let formData = new FormData();             
        let collectionName = $(this).data('collection');
        let parentContainer = $(this).data('container');   

        formData.append('media_collection', collectionName);

        for(i = 0; i < this.files.length; i++) {
            formData.append('media[]', this.files[i]);
        }   

        var url = `/admin/unit_types/${unit_type_id}/addMedia`;

        axios.post(url,
            formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
        ).then( function (response) {
            if ( response.status == 200 ) { 
                response.data.forEach( function (media) {
                    appendMedia($('#'+parentContainer), media);
                });
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

    $(document).on('click', '.thumbnial-delete-btn', function (e) {
        e.preventDefault();

        var unit_type_id = $('#unit_type_id').val();
        var ele = $(this);        
        var media_id =  ele.data('id')
        var url = `/admin/unit_types/${unit_type_id}/deleteMedia`;
        
        axios.post(url, {
            '_method' : 'DELETE',
            'media_id' : media_id

        }).then( function (response) {
           
            if ( response.status == 200 ) {
                ele.parent('figure').remove();
            }
        })
        .catch( function ( error ){           
            Swal.fire(
                'Error',
                error.response.data.message,
                'error'
            );
        });
    }) 
</script>
@endpush
