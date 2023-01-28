@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.categories.update', ['id' => $category->getKey()] ) }}" novalidate="novalidate" autocomplete="false">
    @csrf        
    {{ method_field('PUT') }}
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{__("Category")}}</div>
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
                            <div class="col-lg form-group">
                                <label for="">{{ __('Name') }}:</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') ?? $category->name }}">
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-lg form-group">
                                <label for="description">{{ __('Description') }}:</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') ?? $category->description }}</textarea>
                             
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{ __("Update")}} {{ __("Category") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Category") }} {{__("List")}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
