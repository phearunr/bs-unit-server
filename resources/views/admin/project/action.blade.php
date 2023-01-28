<ul class="action-list">
	@if($project->trashed())
		<li><a href="{{ route('admin.projects.restore',['id'=>$project->id]) }}" class="text-success">Restore</a></li>
	@else
		<li><a href="{{ route('admin.projects.edit',['id'=>$project->id]) }}" class="text-success">Edit</a></li>
		<li><a href="{{ route('admin.projects.delete',['id'=>$project->id]) }}" class="text-danger">Remove</a></li>
	@endif
</ul>
