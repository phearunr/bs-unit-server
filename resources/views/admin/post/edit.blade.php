@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="container">
    <form method="POST" action="{{ route('admin.posts.update', ['id' => $post->id]) }}" novalidate="novalidate" autocomplete="false" enctype="multipart/form-data">
    @csrf
    {{ method_field('PUT') }}
    <div class="row">
        <div class="col">           
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
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{__("Post")}}
                    <button type="button" class="btn btn-link float-right" data-toggle="collapse" data-target="#post-body" aria-controls="post-body" aria-expanded="true">
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <div id="post-body" class="collapse show" aria-labelledby="{{ __('Post') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="title">{{ __('Title') }}:</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') ?? $post->title }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="short_description">{{ __('Short Description') }}:</label>
                                <textarea class="form-control" id="short_description" name="short_description" rows="3">{{ old('short_description') ?? $post->short_description }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg form-group">
                                <label for="content">{{ __('Content') }}:</label>
                                <textarea class="form-control" id="content" name="content" rows="10">{{ old('content') ?? $post->content }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary">{{__("Update")}} {{ __("Post") }}</button>
                        </div>
                        <div class="col">
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary float-right">{{ __("Back to") }} {{ __("Post") }} {{__("List")}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ __('Status')  }}                
                    <button type="button" class="btn btn-link float-right" data-toggle="collapse" data-target="#status-body" aria-controls="status-body" aria-expanded="true">
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <div id="status-body" class="collapse show" aria-labelledby="{{ __('Status') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label for="status">{{ __('Visibility') }}:</label>      
                                <select class="form-control" name="status" id="status">
                                @foreach($statuses as $status)
                                    @if( old('status') )
                                        <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : ''  }}>{{ ucfirst($status) }}</option>
                                    @else
                                        <option value="{{ $status }}" {{ $post->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endif
                                @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="published_at">{{ __('Published at') }}: <small>({{ config('app.js_date_format') }} : 23:59:59 )</small></label>
                                <div class="input-group flex-nowrap">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="addon-wrapping"><i class="far fa-calendar-alt"></i></span>
                                    </div>                                    
                                    <input type="text" class="form-control datepicker" name="published_at" id="published_at" aria-label="Publish Date" aria-describedby="addon-wrapping" value="{{ old('published_at') ?? $post->publishDate() }}">
                                     <div class="input-group-prepend">
                                        <span class="input-group-text" id="addon-wrapping"><i class="far fa-clock"></i></span>
                                    </div>
                                    <input type="text" class="form-control time-mask" name="publish_time" id="publish_time" value="{{ old('published_time') ?? $post->publishTime() }}">
                                </div>
                            </div>
                        </div>                     
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    {{ __('Post Type')  }}                
                    <button type="button" class="btn btn-link float-right" data-toggle="collapse" data-target="#type-body" aria-controls="type-body" aria-expanded="true">
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <div id="type-body" class="collapse show" aria-labelledby="{{ __('type') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg">
                                @foreach($types as $type)
                                <div class="form-check">
                                    @if( old('type') )
                                        <input class="form-check-input" type="radio" name="type" id="post-type-{{ $type }}" value="{{$type}}" {{ old('type') == $type ? 'checked' : '' }}>
                                        <label class="form-check-label" for="post-type-{{ $type }}">
                                            {{ ucfirst($type) }}
                                        </label>
                                    @else
                                        <input class="form-check-input" type="radio" name="type" id="post-type-{{ $type }}" value="{{$type}}" {{ $post->type == $type ? 'checked' : '' }}>
                                        <label class="form-check-label" for="post-type-{{ $type }}">
                                        {{ ucfirst($type) }}
                                        </label>
                                    @endif                                    
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    {{ __('Category')  }}                
                    <button type="button" class="btn btn-link float-right" data-toggle="collapse" data-target="#category-body" aria-controls="category-body" aria-expanded="true">
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <div id="category-body" class="collapse show" aria-labelledby="{{ __('Category') }}" >
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg category-card">
                                @foreach($categories as $category)
                                <div class="form-check">
                                    @if( old('category') )
                                        <input class="form-check-input" type="checkbox" name="category[]" id="category-{{ $category->slug }}" value="{{$category->id}}" 
                                        {{ in_array($category->id, old('category')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category-{{ $category->name }}">
                                            {{ $category->name }}
                                        </label>
                                    @else
                                        <input class="form-check-input" type="checkbox" name="category[]" id="category-{{ $category->slug }}" value="{{ $category->id }}" 
                                        {{ in_array($category->id, $post_category_array) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category-{{ $category->name }}">
                                            {{ $category->name }}
                                        </label>
                                    @endif                                    
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    {{ __('Thumbnail Image')  }}                
                    <button type="button" class="btn btn-link float-right" data-toggle="collapse" data-target="#thumbnail-image-body" aria-controls="thumbnail-image-body" aria-expanded="true">
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <div id="thumbnail-image-body" class="collapse show" aria-labelledby="{{ __('Thumbnail Image') }}" >
                    <div class="card-body">
                        <div class="row">                                                    
                            <div class="col-lg">                              
                                @if($post->thumbnail_image_url)                           
                                <figure class="figure border">
                                    <a href="{{ $post->thumbnail_image_url }}" target="_blank">
                                        <img src="{{ $post->thumbnail_image_url }}" class="img-fluid">
                                    </a>
                                </figure>
                                @endif
                                <input type="file" class="form-control-file" name="thumbnail_image_url" id="thumbnail_image_url" />
                                <small class="form-text text-muted">{{ __('Image must be square. eg : 100x100') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    {{ __('Featured Image')  }}                
                    <button type="button" class="btn btn-link float-right" data-toggle="collapse" data-target="#featured-image-body" aria-controls="featured-image-body" aria-expanded="true">
                        <i class="fas fa-angle-up"></i>
                    </button>
                </div>
                <div id="featured-image-body" class="collapse show" aria-labelledby="{{ __('Featured Image') }}" >
                    <div class="card-body">
                        <div class="row">                                                    
                            <div class="col-lg">                              
                                @if($post->featured_image_url)                           
                                <figure class="figure border">
                                    <a href="{{ $post->featured_image_url }}" target="_blank">
                                        <img src="{{ $post->featured_image_url }}" class="img-fluid">
                                    </a>
                                </figure>
                                @endif
                                <input type="file" class="form-control-file" name="featured_image_url" id="featured_image_url" />
                                <small id="emailHelp" class="form-text text-muted">Click the choose file to upload new image if you wan to change the existing one.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('js/summernote-plugin/summernote-ext-youtube-video.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){       

        // var selector = document.getElementsByClassName("time-mask");
        // Inputmask({"mask": "(999) 999-9999"}).mask(selector);
        // $('.time-mask').inputmask({ alias: "datetime", mask : "HH:MM:ss" });

        $('.time-mask').inputmask("datetime", {inputFormat:'isoTime'});
       
        $('#content').summernote({
            toolbar : [
                [ 'style' , ['style', 'bold', 'italic', 'underline', 'clear'] ],
                ['para', ['ul', 'ol', 'paragraph']],               
                [ 'misc', ['fullscreen', 'codeview', 'undo', 'redo'] ],
                [ 'insert', ['ytVideo'] ]
            ],
            popover: {
                image: []
            },
            height: 300,
        });
    });
   
</script>
@endpush
