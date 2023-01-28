<a href="{{ route('admin.unit_deposit_requests.show', [ 'id' => $notification->data['id'], 'read' => $notification->id ]) }}"
	class="list-group-item list-group-item-action {{ $notification->read() ? 'list-group-item-secondary' :'' }} d-flex ">
	<div class="w-100 align-self-start">    
		<p class="mb-0 pb-0">{!! __('unit_hold_request.notification.rejected', ['unit_code' => $notification->data['additional_data']['unit_code']]) !!}</p>
		<small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
    </div>
	@if(!$notification->read())
		<button data-id="{{ $notification->id }}" class="btn btn-primary btn-sm align-self-center btn-mark-noti-read content-nowrap">
		{{__("Mark as read")}}
		</button>
	@endif
</a>