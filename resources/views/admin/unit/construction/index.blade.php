@extends('layouts.app')

@section('content')
<div class="container"> 
    <div class="row justify-content-center">
        <div class="col-lg-4">
            @include('admin.unit.partial.info_sidebar', ['unit' => $unit])
        </div>
        <div class="col-lg-8">
            <ul class="yk-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.units.transactions.index', ['unit_id' => $unit->id]) }}">Transactions</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link active" href="javascript::void(0)">Construction Progress</a>
                </li>               
            </ul>
            <div class="row">
                <div class="col">
                    <div class="p-4 bg-white">
                        <unit-construction-procedure unit-id="{{ $unit->id }}" :show-summary="true" :editable="{{ (Auth::user()->can('update-unit-construction')) ? 'true' : 'false' }}"></unit-construction-procedure>
                        <h4>Comments:</h4>
                        <unit-comment-list unit-id="{{ $unit->id }}"></unit-comment-list>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection