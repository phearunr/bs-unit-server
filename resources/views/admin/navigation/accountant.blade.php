<li class="nav-item">
    <a class="nav-link" href="{{ route('home') }}">{{ __('Dashboard') }}</a>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __("Accounting") }}
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{route('admin.unit_deposit_requests.index')}}">{{ __("Unit Deposit Request") }}</a>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.units.index') }}">{{ __("Units") }}</a>
</li>