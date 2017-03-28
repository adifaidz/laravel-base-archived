{{-- $route and $method are required to be pass for each @include --}}

{{-- This needs to be in partial to avoid redundancy of code to pass reference table data --}}

<client-account-form
  :user="{{$userJson or '{}'}}"
  class="col-md-12"
  action="{{$route}}"
  method="{{$method}}"
>
  {{ csrf_field() }}
  {{ method_field($method) }}
</client-account-form>
