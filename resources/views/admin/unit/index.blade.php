@extends('layouts.app')

@section('styles')
<style type="text/css">  
.switch {
  position: relative;
  display: inline-block;
  width: 52px;
  height: 24px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 24px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.units.index') }}" name="user-search-from" novalidate="novalidate" autocomplete="false">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            {{ __("Unit List") }} : 
                            @can('create-unit')
                            <a href="{{route('admin.units.create')}}" class="btn btn-primary btn-sm">{{ __("New Unit") }}</a>
                            @endcan
                            <div class="btn-group">
                              
                                <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Other Task
                                </button>
                              
                                <div class="dropdown-menu">                                 
                                    <a href="{{ route('admin.unit_actions.index') }}" class="dropdown-item">Unit Action List</a>
                                    <div class="dropdown-divider"></div>
                                    @can('import-unit')
                                    <a class="dropdown-item" href="{{route('admin.units.import')}}">{{ __("Import") }} {{ __("Units") }}</a>
                                    @endcan
                                    @can('modify-status-unit')
                                    <a class="dropdown-item" href="{{ route('admin.units.bulk_status_modify') }}">{{ __("Status Modify") }} </a>
                                    @endcan
                                    @can('export-unit')
                                    <a class="dropdown-item" href="{{route('admin.units.export')}}">{{ __("Export") }} {{ __("Units") }}</a>
                                    @endcan
                                    @can('import-unit-handover')
                                    <a class="dropdown-item" href="{{route('admin.unit_handovers.import')}}">{{ __("Import") }} {{ __("Unit Handover") }}</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-auto" style="width:400px;">                           
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Unit Code" aria-label="Unit Code" aria-describedby="button-search" name="term" value="{{ Request::query('term') ? Request::query('term') : '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" id="search-button">Search</button>
                                    <a class="btn btn-outline-secondary" data-toggle="collapse" href="#sub-header-collapse">More Filter</a>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>  
                <div class="card-sub-header card-bg-grey collapse {{ array_except(Request::query(),'page') ? 'show' : '' }}" id="sub-header-collapse">
                    <div class="sub-header-box-wrapper">
                        <div class="form-row">
                            <div class="input-group input-group-sm col-md-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="unit_type">Unit Type</label>
                                </div>
                                <select class="form-control" name="unit_type" id="unit_type">
                                    <option value="">Choose...</option>
                                @foreach ( $projects as $project )
                                    <optgroup label="{{ $project->name_en }}">
                                    @foreach( $project->unitTypes as $unit_type )
                                        <option value="{{ $unit_type->id }}" 
                                                {{ $unit_type->id == Request::query('unit_type') ? "selected" : "" }} >
                                                {{ $unit_type->name }}
                                        </option>
                                    @endforeach
                                    </optgroup>
                                @endforeach
                                </select> 
                            </div>  
                            <div class="input-group input-group-sm col-md-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="status">Status</label>
                                </div>
                                <select class="form-control" name="status" id="status">
                                    <option value="">Choose...</option>
                                    @foreach($statuses AS $status)
                                    <option value="{{ $status }}" {{ Request::query('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group input-group-sm col-md-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text">Active</label>
                                </div>
                                <select class="form-control" name="active" id="active">
                                    <option value="">Choose...</option>
                                    <option value="no" {{ Request::query('active') == 'no' ? 'selected' : '' }}>No</option>
                                    <option value="yes" {{ Request::query('active') == 'yes' ? 'selected' : '' }}>Yes</option>                                    
                                </select>
                            </div>
                            <button class="btn btn-sm btn-primary" type="submit" id="fileter-button">Show</button>
                            <a href="{{ route('admin.units.index') }}" class="btn btn-secondary btn-sm ml-md-2">Clear Filter</a>
                        </div>
                    </div>
                </div>             
                <div class="card-body p-0">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <table class="table table-hover table-action mb-0">
                        <thead>
                            <tr>                                
                                <th scope="col">Code</th>
                                <th width="150px">Active</th>
                                <th width="200px">Price</th>
                                <th width="180px">Status</th>                             
                                <th width="180px">Last Status</th>    
                                <th width="30px"></th>                          
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($units AS $unit)
                            <tr>
                                <td  scope="row" class="action-td">
                                    <a href="{{ route('admin.units.show',['id'=>$unit->id]) }}" class="title">
                                        <strong>{{ $unit->code }}</strong>
                                    </a>                                    
                                    <span class="d-block text-muted">{{ $unit->unitType->name }} | {{ $unit->unitType->project->name_en }}</span>                                    
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" class="active-checkbox" 
                                           {{ $unit->trashed() ? '' : 'checked' }} 
                                            data-id="{{ $unit->id }}"
                                        />
                                        <span class="slider round"></span>
                                    </label>
                                </td>                             
                                <td>  
                                    $ {{ number_format($unit->price, 2) }} 
                                    <span class="d-block">
                                        <input type="checkbox" class="form-check-input saleable-checkbox" data-id="{{ $unit->id }}"
                                            {{ $unit->saleable == true ? 'checked' : '' }} >
                                        <label class="form-check-label" for="exampleCheck1">{{ __("Saleable") }}</label>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-pill badge-secondary">{{ $unit->action->createdBy->name }}</span> <br>
                                    <span class="{{ $unit->action->getActionCss() }}">{{ $unit->action->action }}</span>
                                    <span class="{{ $unit->action->getStatusActionCss() }}">{{ $unit->action->status_action }}</span>
                                </td>
                                <td>
                                    <span class="d-block">{{ $unit->action->created_at }}</span>
                                </td>
                                <td>
                                    @can('update-unit')
                                    <div class="btn-group">
                                        <a href="#" class="text-primary" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false"><i class="fas fa-lg fa-ellipsis-v"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                                            <a href="{{ route('admin.units.edit', ['id'=>$unit->id]) }}" class="dropdown-item">{{ __("Edit") }}</a>
                                            <a href="{{ route('admin.units.status.change', ['id'=>$unit->id]) }}" class="dropdown-item">{{ __("Change Status") }}</a>
                                        </div>
                                    </div>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            </form>
            {{ $units->appends(request()->except(['page','_token'])) }}
        </div>
    </div>
</div>
@endsection

@push("scripts")
<script type="text/javascript">
    $('.saleable-checkbox').on("click", function (e){
        let id = e.target.dataset.id;
        e.preventDefault();

        axios.post('/admin/units/'+ id +'/updateSaleable' , {
            saleable: e.target.checked         
        })
        .then(function (response) { 
            $(e.currentTarget).prop("checked", !e.target.checked);          
        })
        .catch(function (error) {
            Swal.fire(
               'Error',
                error.response.data.error.message,
                'error'
            );
        });
    });

    $('.active-checkbox').on("click", function (e){
        let id = e.target.dataset.id;
        e.preventDefault();     

        axios.post('/admin/units/'+ id +'/updateActive' , {
            active: e.target.checked         
        })
        .then(function (response) { 
          
            $(e.currentTarget).prop("checked", !e.target.checked);
            // $(e.currentTarget).trigger(e.type);          
        })
        .catch(function (error) {
            Swal.fire(
               'Error',
                error.response.data.error.message,
                'error'
            );
        });
    });
</script>
@endpush
