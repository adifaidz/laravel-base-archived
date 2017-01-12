@extends('layouts.admin')

@section('title')
  Permission List
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
  Permission
@endsection

@section('page-desc')
  Permission List
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Permission List</h3></div>
    <div class="box-body">
      <generic-table
        api-url="{{route('api.permission')}}"
        create-url="{{route('admin.permission.create')}}"
        show-url="{{route('admin.permission.show', ['id' => null])}}"
        edit-url="{{route('admin.permission.edit', ['id' => null])}}"
        delete-url="{{route('admin.permission.destroy', ['id' => null])}}"
        :columns="get('columns')"
        :sort-order="get('sortOrder')"
      ></generic-table>
    </div>
    <div class="box-footer"></div>
</div>
@endsection
