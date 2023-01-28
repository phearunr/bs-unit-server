<div class="d-flex border w-100 bg-white my-2 shadow-sm">
    <div class="p-2" style="width:150px;">
        <a href="{{ $user->avatar_url }}" data-lightbox="lightbox-user-{{ $user->id }}" data-title="{{ $user->name }}">
            <img src="{{ $user->avatar_url }}" class="img-fluid" alt="{{$user->name}}"/>
        </a>
    </div>
    <div class="w-100">
        <a href="javascript::void(0)" class="d-block w-100 font-weight-bold pt-2">{{ $user->name }}</a>
        <span class="text-muted d-block">{{ str_replace('_',' ', title_case($user->roles->first()->name)) }}</span>
        <span class="text-muted d-block d-none d-sm-block d-md-none">{{ $user->phone_number }}</span>
    </div>
    <div class="p-2 d-none d-md-block d-lg-block d-xl-block">
        <span class="text-nowrap d-block text-muted">Phone Number</span>
        <span class="font-weight-bold">{{ $user->phone_number }}</span>
    </div>
    <div class="justify-content-end align-self-center px-3">
        <div class="btn-group">
            <a href="#" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="true" class="text-primary">
                <i class="fas fa-lg fa-ellipsis-v"></i>
            </a> 
            <div class="dropdown-menu dropdown-menu-right">   
                <a class="dropdown-item" href="javascript:void(0)">View Profile</a>
            </div>
        </div>
    </div>
</div>