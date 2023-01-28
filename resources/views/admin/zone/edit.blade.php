@extends('layouts.app')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/flickity.min.css') }}">
<style type="text/css">
    .unit-type-carousel-item {
        width: 300px;
        margin: 0 10px;
    }

    .unit-type-carousel-item .card-img-top {
        width: 100%;
        height: 10vw;
        object-fit: cover;
    }

    .btn-group-action-absolute {
        position: absolute;     
        top: 1rem;
        right: 1rem;
    }

    @media (max-width: 768px) { 
        .unit-type-carousel-item {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <form method="POST" action="{{ route('admin.zones.update', [ 'id' => $zone->id ]) }}"> 
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="project_id">Name:</label> 
                        <input type="text" class="form-control" name="name"  value="{{ old('name', $zone->name) }}">
                    </div>   
                    <div class="form-group">
                        <label for="project_id">Project:</label> 
                        <select name="project_id" id="project_id" class="form-control">
                            @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ (old('project_id', $zone->project_id) == $project->id) ? 'selected' : '' }}>{{ $project->name_en }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">{{ __('Update') }}</button>
                </div>
            </div>
            </form>
        </div>
        <div class="col-md-8">
            <h5 class="page-title">Units:</h5>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">{{ __("Find unit to include:") }}</span>
                </div>
                <select class="form-control" id="unit_search_control">
                </select>
            </div>

            <div class="card">
                <div class="carb-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Unit Type</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>F1-01</td>
                                <td>Flat</td>
                                <td><button type="button" data-id="1" class="btn btn-sm btn-danger btn-unit-zone-delete">Remove</button></td>
                            </tr>
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

    function formatUnit(unit) {
        if (unit.loading) { return unit.text; } 
       
        return `
            <p class="font-weight-bold mb-0">${unit.code}</p>            
        `;
    }

    $("#unit_search_control").on('select2:select', function(e){
        item = e.params.data;        
        console.log(item);
    });

    let project_id;

    $('select[name="project_id"]').on('change', function () {
        project_id = this.value;
    })

    $(document).ready(function(){
        $('select[name="project_id"]').trigger('change');

        $("#unit_search_control").select2({
            theme: "bootstrap4",
            ajax: {
                delay: 1000,
                url: `/admin/projects/${project_id}/units`,
                dataType: 'json',
                data: function (params) {
                    return {                        
                        code: $.trim(params.term),
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {                 
                    params.page = params.page || 1;
                    return {
                        results: data,
                    };
                },
                cache: true
            },            
            placeholder: 'Search for a unit',
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 2,
            templateResult: formatUnit
        });
    });
</script>
@endpush
