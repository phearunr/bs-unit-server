@section('styles')
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
    	<div class="col-lg-10">
            <div class="row">
                @foreach($projects as $project) 
                <div class="col-lg-12 mb-3">
                    <div class="item-container">
                        <div class="item-feature-image"><img class="d-flex flex-row" src="{{ $project->feature_image_url }}" alt="Card image cap"></div>
                        <div class="item-content position-relative">
                            <div class="item-body">
                                <h5><a href="{{ route('admin.projects.show', ['id' => $project->id]) }}">{{ $project->name }}</a></h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $project->name_en }}</h6>
                                <ul class="list-inline pl-0 mb-0">
                                    <li class="list-inline-item"><i class="fas fa-hashtag"></i> {{ $project->short_code }}</li>
                                    <li class="list-inline-item"><i class="fas fa-map-marked-alt"></i> {{ $project->address }}</li>                               
                                    <li class="list-inline-item">{!! $project->getPublishedHtmlStatus() !!} {{ $project->is_published ? 'Active' : 'Removed'}}</li>
                                </ul>
                                
                            </div>
                            <div class="item-footer">                               
                                <small class="text-muted"><i class="far fa-clock"></i> Last updated: {{ $project->updated_at->diffForHumans() }} <i class="fas fa-user-alt"></i> Updated by: {{ $project->createdBy->name }}</small>
                            </div>

                            <div class="btn-group btn-group-action-absolute">
                                <a href="#" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="true" class="text-primary"><i class="fas fa-lg fa-ellipsis-v"></i></a> 
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{ route('admin.projects.master_plan', [ 'id' => $project->id]) }}" class="dropdown-item">{{ __("View Master Plan") }}</a>
                                </div>
                            </div>
                        </div>
                    </div>                  
                </div>
                @endforeach
            </div>           
        </div> 
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">	
</script>
@endpush