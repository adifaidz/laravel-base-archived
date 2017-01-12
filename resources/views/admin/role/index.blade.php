@extends('layouts.admin')

@section('title')
  Role List
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
          name:'display_name',
          title: 'Display Name'
        },
        {
          name:'description',
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
  Role
@endsection

@section('page-desc')
  Role List
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Role List</h3></div>
    <div class="box-body">
      <generic-table
        api-url="{{route('api.role')}}"
        create-url="{{route('admin.role.create')}}"
        show-url="{{route('admin.role.show', ['id' => null])}}"
        edit-url="{{route('admin.role.edit', ['id' => null])}}"
        delete-url="{{route('admin.role.destroy', ['id' => null])}}"
        :columns="get('columns')"
        :sort-order="get('sortOrder')"
      ></generic-table>
    </div>
    <div class="box-footer"></div>
</div>
@endsection
