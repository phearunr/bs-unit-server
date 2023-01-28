@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.banners.update', ['id' => $banner->id]) }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data">
        @csrf   
        {{ method_field('PUT') }}       
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{__("Banner")}} : {{ __("Edit") }}</div>
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
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="url">{{ __('Action Url') }}:</label>
                                <input type="text" class="form-control" name="url" id="url" placeholder="https://example.com" value="{{ old('url') ? old('url') : $banner->url }}">
                            </div>                           
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="expired_at">{{ __('Expiration Date') }}:</label>
                                <input type="text" class="form-control datepicker" name="expired_at" id="expired_at"
                                value="{{ old('expired_at') ? old('expired_at') : $banner->expired_at->toSystemDateString() }}">
                            </div>
                            <div class="form-group col-md">
                                <label for="order">{{ __('Order') }}:</label>
                                <input type="number" class="form-control" name="order" id="order"
                                value="{{ old('order') ?? $banner->order }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="">{{ __('Image') }}:</label>
                                <input type="file" class="form-control-file" name="image_url">
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    {{ __('The image should be in 16:9 ratio (1920x1080, 1600×900, 1366×768, 1024×576).') }}
                                </small>
                            </div>
                        </div>
                        @if( $banner->getOriginal('image_url') )
                        <figure class="figure border">
                            <a href="{{ $banner->image_url  }}" target="_blank">
                                <img src="{{ $banner->image_url  }}" class="figure-img img-fluid rounded">
                            </a>
                        </figure>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">{{__("Update New")}} {{ _("Banner") }}</button>
                            </div>
                            <div class="col">
                                <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ _("Banner List") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
