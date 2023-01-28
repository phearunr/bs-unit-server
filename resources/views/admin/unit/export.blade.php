@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.units.export') }}" novalidate="novalidate" autocomplete="false" id="unit-export-form">
        @csrf        
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{__("Unit")}} : {{ __("Export") }}</div>
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
                            <div class="col">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="selected_type" id="unit_type_option" value="unit_type" checked="checked">
                                    <label class="form-check-label" for="unit_type_option">{{ __("Unit Type") }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="selected_type" id="project_option" value="project">
                                    <label class="form-check-label" for="project_option">{{ __("Project") }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">                            
                            <div class="col input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="unit_import">Select item export:</span>
                                </div>
                                <select class="custom-select" id="selected_id" name="selected_id">                               
                                </select>
                               <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">{{__("Export")}} {{ __("Unit") }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">                          
                            <div class="col">
                                <a href="{{ route('admin.units.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Unit") }} {{__("List")}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    const projects = {!! $projects !!};

    $(document).ready( function() {
        $('input[name="selected_type"]').change(function (e){            
            if ( e.target.checked ) {
                const type = e.target.defaultValue;
                var select_element = $('#selected_id');
                select_element.empty();        
                if ( type === 'project' ) {
                    $.each(projects, function (i, project) {
                        select_element.append(new Option(project.name_en,project.id));
                    });            
                } else {
                    $.each(projects, function (i, project) {
                        var optgroup = $('<optgroup>');
                        optgroup.attr('label', project.name_en);

                        select_element.append(optgroup);
                        $.each(project.unit_types, function(i, unit_type){
                            optgroup.append(new Option(unit_type.name, unit_type.id));
                        });
                    });
                }
            }             
        }); 

        $('input[name="selected_type"]').trigger('change');
    });
</script>
@endpush
