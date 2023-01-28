@extends('layouts.app')

@section('content')
<div class="container">      	
	@auth
		@includeIf('admin.dashboard.'.auth()->user()->roles()->first()->name)
	@endauth
</div>
@endsection
