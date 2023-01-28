@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.projects.restore', [ 'id' => $project->id ]) }}" novalidate="novalidate" autocomplete="false">
    @csrf          
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __("Restore") }} {{__("Project")}} : <strong>{{ $project->name }}</strong></div>
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
                        <input type="hidden" name="id" value="{{ $project->id }}" readonly="readonly">
                        <p class="mb-0">Are you sure want to recover the project : <strong>{{ $project->name }}</strong>?</p>
                        <p class="text-muted"><small>Recovered resource will be available for user.</small></p>
                    </div>
                    
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{ __("Yes, restore it.") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary float-right">{{ __("No, Back to Project list.") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
