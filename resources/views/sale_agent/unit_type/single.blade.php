@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.css" integrity="sha512-Woz+DqWYJ51bpVk5Fv0yES/edIMXjj3Ynda+KWTIkGoynAMHrqTcDUQltbipuiaD5ymEo9520lyoVOo9jCQOCA==" crossorigin="anonymous" />
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-3">
                @include('sale_agent.unit_type.partial.info_sidebar', ['unit_type' => $unit_type])              
            </div>
        </div>
        <div class="col-lg-8">    
            <ul class="yk-nav">
                <li class="nav-item active">
                    <a href="javascript::void(0)" class="nav-link active">Units</a>
                </li>
            </ul>
            <form>                  
            <div class="card">
                <div class="card-body bg-light">
                    <div class="row">
                        <div class="col-md-4 mb-md-0 form-group">
                            <label for="term">Unit Code:</label>
                            <input type="text" class="form-control form-control-sm" value="{{ Request::query('term') }}" id="term" name="term" placeholder="Unit Code">
                        </div>
                        <div class="col-md-4 mb-md-0 form-group">
                            <label for="term">Status:</label>
                            <select class="form-control form-control-sm" name="status" id="status">
                                <option value="">Choose...</option>
                                @foreach($unit_status AS $status)
                                <option value="{{ $status }}" {{ Request::query('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-md-0 d-flex align-items-end">
                            <button class="btn btn-sm btn-primary" type="submit">Show</button>
                            <a href="{{ URL::current() }}" class="btn btn-secondary btn-sm ml-md-2">Clear</a>
                        </div>
                    </div>
                    <!-- <div class="form-row">
                        
                    </div> -->
                </div>
            </div>
            </form>
            <div class="row">
                <div class="col">
                    @foreach($units as $unit)
                    <div class="d-flex border unit-container w-100 bg-white my-2 shadow-sm">
                        <div class="align-self-center w-100 px-3 py-2">
                            <h5 class="mb-0 font-weight-bold">
                                {{ $unit->code }}
                            </h5>
                            <span class="text-muted d-block">{{ $unit->unitType->name }} | {{ $unit->unitType->project->name_en }} | {{ ($unit->zone) ? $unit->zone->name : 'Unassigned Zone' }}</span>
                        </div>
                        <div class="align-self-center  px-3" style="width:300px;">                    
                            <span class="{{ $unit->action->getActionCss() }}">{{ $unit->action->action }}</span>                         
                        </div>
                        <div class="align-self-center p-3" style="width:250px;">
                            <span class="d-block text-right">Price</span>
                            <h5 class="m-0 font-weight-bold text-nowrap text-right">
                                $ {{ number_format($unit->price) }}
                            </h5> 
                        </div>                          
                    </div>
                    @endforeach
                    {{ $units->onEachSide(1)->appends(request()->except(['page','_token'])) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push("scripts")
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js" integrity="sha512-k2GFCTbp9rQU412BStrcD/rlwv1PYec9SNrkbQlo6RZCf75l6KcC3UwDY8H5n5hl4v77IDtIPwOk9Dqjs/mMBQ==" crossorigin="anonymous"></script>

<script type="text/javascript">
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })
</script>
@endpush
