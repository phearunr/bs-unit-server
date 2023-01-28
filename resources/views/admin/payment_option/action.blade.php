<ul class="action-list">
	@if($payment_option->trashed())
		<li><a href="{{ route('admin.payment_options.restore',['id'=>$payment_option->id]) }}" class="text-success">Restore</a></li>
	@else
		<li><a href="{{ route('admin.payment_options.edit',['id'=>$payment_option->id]) }}" class="text-success">Edit</a></li>
		<li><a href="{{ route('admin.payment_options.delete',['id'=>$payment_option->id]) }}" class="text-danger">Remove</a></li>
	@endif
</ul>
