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
                    <a class="nav-link active" href="javascript::void(0)">Transaction</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.units.construction_procedures.index', ['id' => $unit->id]) }}">Construction Progress</a>
                </li>
            </ul>
            <div class="row">
                <div class="col">
                    <div class="bg-white">
                        <unit-transaction-table unit-id="{{ $unit->id }}"></unit-transaction-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection