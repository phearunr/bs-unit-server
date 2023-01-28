@extends('layouts.app')

@section('styles')

@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.zones.store') }}"  >
    @csrf        
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__("Unit")}} : {{ __("Create New Zone") }}</div>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="project">Project</label>
                                <select name="project_id" class="form-control">

                                    @foreach($project as $projects)
                                    <option value="{{$projects->id}}">{{$projects->name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Zone name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary">{{ __("Create") }}</button>
                        </div>
                        <div class="col">
                            <a href="{{ route('admin.units.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Unit List") }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection


