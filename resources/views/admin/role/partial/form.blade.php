{{-- $route and $method are required to be pass for each @include --}}

{{-- This needs to be in partial to avoid redundancy of code to pass reference table data --}}

<admin-role-form
  :role="{{$roleJson or '{}'}}"
  :permissions="{{$permissions}}"
  class="col-md-6 col-md-offset-3"
  action="{{$route}}"
  method="{{$method}}"
>
  {{ csrf_field() }}
  {{ method_field($method) }}
</admin-role-form>
