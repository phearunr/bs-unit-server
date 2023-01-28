@foreach( $permissions as $group => $items )
    <div class="row">
        <div class="col-lg-12">
            <p class="font-weight-bold">{{ str_replace('-', ' ', title_case($group)) }}</p>
        </div>
    </div>
    <div class="row mb-3 mx-3">
    @foreach( $items as $item )
        <div class="col-md-3 form-check">
            <input class="form-check-input" type="checkbox" 
                name="permissions[]"
                value="{{$item['name']}}" id="permission-{{$item['name']}}" 
                {{ in_array($item['id'], $role_have_permission) ? "checked" : "" }}
            >
            <label class="form-check-label" for="defaultCheck1">
               {{ str_replace('-',' ', title_case($item['name']))}}
            </label>
        </div>
    @endforeach
    </div>
@endforeach

