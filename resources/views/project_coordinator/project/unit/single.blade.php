@extends('layouts.app')

@section('content')
<div class="container"> 
    <div class="row justify-content-center">
        <div class="col-lg-4">
            @include('admin.unit.partial.info_sidebar', ['unit' => $unit])
        </div>
        <div class="col-lg-8">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="transaction-tab" data-toggle="tab" href="#transaction" role="tab" aria-controls="transaction" aria-selected="true">Transaction</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="construction-progress-tab" data-toggle="tab" href="#construction-progress" role="tab" aria-controls="construction-progress" aria-selected="false">Construction Progress</a>
                </li>
            </ul>
            <div class="tab-content bg-white" id="myTabContent">
                <div class="tab-pane fade show active" id="transaction" role="tabpanel" aria-labelledby="transaction-tab">
                    <unit-transaction-table unit-id="{{ $unit->id }}"></unit-transaction-table>
                </div>
                <div class="tab-pane fade" id="construction-progress" role="tabpanel" aria-labelledby="construction-progress-tab">
                    <div class="p-4">
                        <unit-construction-procedure unit-id="{{ $unit->id }}" :editable="{{ (Auth::user()->can('update-unit-construction')) ? 'true' : 'false' }}"></unit-construction-procedure>
                    </div>
                    <div class="px-4 pb-2">
                        <h4>Comments:</h4>
                        <unit-comment-list unit-id="{{ $unit->id }}" :allow-comment="false"></unit-comment-list>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection