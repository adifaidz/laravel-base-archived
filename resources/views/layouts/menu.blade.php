<ul class="sidebar-menu">
  <li class="header">MAIN NAVIGATION</li>
  <!-- Optionally, you can add icons to the links -->
  @include('base::layouts.menu-items', array('items' => $menu->roots()))
</ul>
