<a href="#"
	class="list-group-item list-group-item-action {{ $notification->read() ? 'list-group-item-secondary' : '' }} d-flex noti-item">
	<div class="w-100 align-self-start">    
		<p class="mb-0 pb-0">{!! __('registration.notification', ['name' => $notification->data['user_name']]) !!}</p>
		<small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
    </div>
	@if(!$notification->read())
		<button data-id="{{ $notification->id }}" class="btn btn-primary btn-sm align-self-center btn-mark-noti-read content-nowrap">
		{{__("Mark as read")}}
		</button>
	@endif
</a>