<ul class="action-list">
	@if($unit_type->trashed())
		<li><a href="{{ route('admin.unit_types.restore',['id'=>$unit_type->id]) }}" class="text-success">Restore</a></li>
	@else
		<li><a href="{{ route('admin.unit_types.edit',['id'=>$unit_type->id]) }}" class="text-success">Edit</a></li>
		<li><a href="{{ route('admin.unit_types.clone',['id'=>$unit_type->id]) }}" class="text-primary">Clone</a></li>
		<li><a href="{{ route('admin.unit_types.delete',['id'=>$unit_type->id]) }}" class="text-danger">Remove</a></li>
	@endif
</ul>
