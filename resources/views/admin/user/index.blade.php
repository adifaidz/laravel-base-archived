@extends('base::layouts.admin')

@section('title')
  User List
@endsection

@section('head')
  <script>
    window.Laravel = { csrfToken: '{{ csrf_token() }}' };
    var params = {
      columns: [
        {
          name:'id',
          visible: false
        },
        {
          name:'name',
          sortField: 'name'
        },
        {
          name:'email',
        },
        {
          name:'__component:base-actions'
        }
      ],
      sortOrder: [{
          field: 'name',
          direction: 'asc',
      }]
    }
  </script>
@endsection

@section('page-header')
  User
@endsection

@section('page-desc')
  User List
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">User List</h3></div>
    <div class="box-body">
      <generic-table
        api-url="{{route('api.user')}}"
        create-url="{{route('admin.user.create')}}"
        show-url="{{route('admin.user.show', ['id' => null])}}"
        edit-url="{{route('admin.user.edit', ['id' => null])}}"
        delete-url="{{route('admin.user.destroy', ['id' => null])}}"
        :columns="get('columns')"
        :sort-order="get('sortOrder')"
      ></generic-table>
    </div>
    <div class="box-footer"></div>
</div>
@endsection
