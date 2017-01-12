@foreach($items as $item)
  <li@lm-attrs($item) @if($item->hasChildren())class ="treeview"@endif @lm-endattrs>
    @if($item->link) <a@lm-attrs($item->link) @if($item->hasChildren())  @endif @lm-endattrs href="{!! $item->url() !!}">
      <i class="{{ $item->attr('icon')}}"></i>
      <span>{!! $item->title !!}</span>
      @if($item->hasChildren())
        <span class="pull-right-container">
          <i class="fa fa-angle-down pull-right"></i>
        </span>
      @endif
    </a>
    @else
      {!! $item->title !!}
    @endif
    @if($item->hasChildren())
      <ul class="treeview-menu">
        @include(config('laravel-menu.views.bootstrap-items'),array('items' => $item->children()))
      </ul>
    @endif
  </li>
  @if($item->divider)
  	<li{!! Lavary\Menu\Builder::attributes($item->divider) !!}></li>
  @endif
@endforeach
