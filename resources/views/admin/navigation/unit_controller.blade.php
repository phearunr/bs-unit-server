<li class="nav-item">
    <a class="nav-link" href="{{ route('home') }}">{{ __('Dashboard') }}</a>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __("Requests") }}
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{route('admin.unit_contract_requests.index')}}">{{ __("Unit Contract Requests") }}</a>
        <a class="dropdown-item" href="{{route('admin.unit_deposit_requests.index')}}">{{ __("Unit Deposit Requests") }}</a>
        <a class="dropdown-item" href="{{ route('admin.unit_hold_requests.index') }}">{{ __("Unit Hold Requests") }}</a>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.units.index') }}">{{ __("Units") }}</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.projects.index') }}">{{ __("Projects") }}</a>
</li>