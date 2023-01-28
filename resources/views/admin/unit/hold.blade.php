@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.units.hold', [ 'id' => $unit->id ]) }}" novalidate="novalidate" autocomplete="false">
    @csrf           
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __("Hold") }} {{__("Unit")}} : <strong>{{ $unit->code }}</strong></div>
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
                        <input type="hidden" name="id" value="{{ $unit->id }}" readonly="readonly">
                        <p class="mb-0 d-inline">Are you sure want to hold unit : <strong>{{ $unit->code.' - '.$unit->unitType->name." | ".$unit->unitType->project->name_en  }} </strong> for <input type="number" name="number_of_day_to_hold" min="1" max="7" class="inline-input text-center" style="width: 50px;" value="1"> day(s)?</p>
                    </div>
                    
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-success">{{ __("Yes, hold it.") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.units.index') }}" class="btn btn-secondary float-right">{{ __("No, Back to Unit list.") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
