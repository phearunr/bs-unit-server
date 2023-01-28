@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.companies.destroy', [ 'id' => $company->id ]) }}" novalidate="novalidate" autocomplete="false">
    @csrf        
    {{ method_field("DELETE") }}
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __("Delete") }} {{__("Company")}} : <strong>{{ $company->name }}</strong></div>
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
                        <input type="hidden" name="id" value="{{ $company->id }}" readonly="readonly">
                        <p class="mb-0">{{ __("Are you sure want to delete the company") }} : <strong>{{ $company->name_en }}</strong>?</p>
                    </div>
                    
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-danger">{{ __("Yes, Delete it.") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.companies.index') }}" class="btn btn-secondary float-right">{{ __("No, Back to Company list.") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
