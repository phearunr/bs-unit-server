@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.discount_promotions.update', ['id' => $discount_promotion->id]) }}" novalidate="novalidate" autocomplete="false">
        @csrf   
        {{ method_field('PUT') }}     
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{__("Discount Promotion")}} : {{ $discount_promotion->name }}</div>
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
                                <label for="name">{{ __('Name') }}: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') ?? $discount_promotion->name }}">
                            </div>                           
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="start_date">{{ __('Start Date') }}:</label>
                                <input type="text" class="form-control datepicker" name="start_date" id="start_date" value="{{ old('start_date') ?? $discount_promotion->start_date->toSystemDateString() }}">
                            </div>
                            <div class="form-group col">
                                <label for="end_date">{{ __('End Date') }}:</label>
                                <input type="text" class="form-control datepicker" name="end_date" id="end_date" value="{{ old('end_date') ?? $discount_promotion->end_date->toSystemDateString() }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="amount">{{ __('Discount Amount') }}:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend3">$</span>
                                    </div>
                                    <input type="text" class="form-control" name="amount" id="amount" value="{{ old('amount') ?? $discount_promotion->amount }}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg">
                                <h5>{{ __("Unit Types") }} :</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ __("Find unit type to include:") }}</span>
                                    </div>
                                    <select class="form-control" id="unit_type_search">                                             
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <table class="table table-bordered" id="table-unit-type">
                                    <thead>
                                        <tr class="bg-grey">
                                            <th scope="col">{{ __('Name') }}</th>                                            
                                            <th scope="col" width="50px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($discount_promotion->items as $item)
                                        <tr>
                                            <td>
                                                <p class="font-weight-bold mb-0">{{ $item->name }}</p>
                                                <span class="d-block text-muted">{{ $item->project->name_en }}</span>
                                            </td>
                                            <td>
                                                <button type="button" data-id="{{ $item->id }}" class="btn btn-sm btn-danger btn-discount-delete">{{ __("Remove") }}</button>
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
                                <button type="submit" class="btn btn-primary">{{__("Update")}} {{ __("Discount Promotion") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.discount_promotions.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Discount Promotion List") }}</a>
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
    const discount_promotion = {!! $discount_promotion->id !!};

    $(document).on('click', '.btn-discount-delete', function (e) {
        var row = $(this).closest('tr');
        var id =  $(this).data('id');
        var url = `/admin/discount_promotions/${discount_promotion}/discount_promotion_items/${id}`;
        axios.post(url, {
            unit_type_id : id,
            _method : 'DELETE'
        })
        .then(function (response) {
            if ( response.status >= 200 && response.status < 300 ) {
                Swal.fire(
                    'Successful',
                    response.data.message,
                    'success'
                );
                row.empty();
            } else {
                alert(response.data.message);
            }
        })
        .catch(function (error) {           
            Swal.fire(
                'Error',
                error.response.data.message,
                'error'
            );            
        });
    });

    function formatUnitType(unit_type) {
        if (unit_type.loading) {
            return unit_type.text;
        } 
       
        return '<p class="font-weight-bold mb-0">' + unit_type.name + '</p>' + 
               '<span class="d-block text-muted">' + unit_type.project.name_en + '</span>';
    }

    function addUnitTypeRow(unit_type) {    
        var tr = $('<tr></tr>');
        var td_text = $('<td></td>');
        var td_action = $('<td></td');
        var delete_button = $(`<button type="button" data-id="${unit_type.id}"></button>`)
                            .addClass('btn btn-sm btn-danger btn-discount-delete')
                            .text('Remove')                                                       
        
        var p_name = $('<p></p>').addClass('font-weight-bold mb-0').text(unit_type.name);
        var span = $('<span></span>').addClass('d-block text-muted').text(unit_type.project.name_en);
        td_action.append(delete_button);
        td_text.append(p_name);
        td_text.append(span);

        tr.append(td_text);
        tr.append(td_action);
        $('#table-unit-type > tbody').append(tr);
    }

    function addUnitTypeToPromotion(unit_type) {
        axios.post('/admin/discount_promotions/'+discount_promotion+'/discount_promotion_items', {
            unit_type_id: unit_type.id                     
        })
        .then(function (response) {
            addUnitTypeRow(response.data);
        })
        .catch(function (error) {           
            console.log(error);
        });
    }

    $("#unit_type_search").on('select2:select', function(e){
        item = e.params.data;        
        addUnitTypeToPromotion(item);
    });

    $(document).ready(function(){
        $("#unit_type_search").select2({
            theme: "bootstrap4",
            ajax: {
                delay: 1000,                         
                url: "/admin/unit_types",
                dataType: 'json',      
                data: function (params) {
                    return {
                        term : $.trim(params.term)
                    };
                },
                processResults: function (data, params) {                 
                    params.page = params.page || 1;
                    return {
                        results: data.data,                      
                    };
                },
                cache: true
            },            
            placeholder: 'Search for a unit type',
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 3,
            templateResult: formatUnitType            
        });
    });
</script>
@endpush
