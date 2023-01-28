<li class="nav-item">
    <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Users
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="{{route('admin.user.all')}}">User List</a>
        <a class="dropdown-item" href="{{route('admin.role.all')}}">Role List</a>   
        <!-- <a class="dropdown-item" href="#">Permission List</a> -->
    </div>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __("Contracts") }}
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('admin.contracts.index') }}">{{ __("Contracts") }}</a>
        <a class="dropdown-item" href="{{ route('admin.unit_handovers.index') }}">{{ __("Unit Handovers") }}</a>
        <a class="dropdown-item" href="{{ route('admin.unit_contract_requests.index') }}">{{ __("Unit Contract Requests") }}</a>
        <a class="dropdown-item" href="{{ route('admin.unit_deposit_requests.index') }}">{{ __("Unit Deposit Requests") }}</a>
        <a class="dropdown-item" href="{{ route('admin.unit_hold_requests.index') }}">{{ __("Unit Hold Requests") }}</a>
    </div>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __("Posts") }}
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{route('admin.posts.index')}}">{{ __("Posts") }}</a>
        <a class="dropdown-item" href="{{route('admin.categories.index')}}">{{ __("Categories") }}</a>
        <a class="dropdown-item" href="{{route('admin.unit_contract_requests.index')}}">{{ __("Media") }}</a>
    </div>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __("More") }}
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{route('admin.companies.index')}}">{{ __("Companies") }}</a>
        <a class="dropdown-item" href="{{route('admin.projects.index')}}">{{ __("Projects") }}</a>
        <a class="dropdown-item" href="{{route('admin.unit_types.index')}}">{{ __("Unit Types") }}</a>
        <a class="dropdown-item" href="{{route('admin.units.index')}}">{{ __("Units") }}</a>
        <a class="dropdown-item" href="{{route('admin.payment_options.index')}}">{{ __("Payment Options") }}</a>        
        <a class="dropdown-item" href="{{route('admin.construction_procedures.index')}}">{{ __("Constructon Procedures") }}</a>
        <a class="dropdown-item" href="{{route('sub_constructors.index')}}">Sub Constructor</a>
        <a class="dropdown-item" href="{{route('admin.discount_promotions.index')}}">{{ __("Discount Promotions") }}</a>
        <a class="dropdown-item" href="{{route('admin.sale_representatives.index')}}">{{ __("Sale Representatives") }}</a>
        <a class="dropdown-item" href="{{route('admin.banks.index')}}">{{ __("Bank Accounts") }}</a>
        <a class="dropdown-item" href="{{route('admin.app_versions.index')}}">{{ __("Mobile App Version") }}</a>
        <a class="dropdown-item" href="{{route('admin.banners.index')}}">{{ __("Banners") }}</a>
    </div>
</li>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __("Misc.") }}
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('purchase_requests.index') }}">{{ __("Purchase Requests") }}</a>
    </div>
</li>