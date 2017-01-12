@extends('layouts.admin')

@section('title')
  Dasboard
@endsection

@section('head')
  <script>
    window.Laravel = { csrfToken: '{{ csrf_token() }}' };
  </script>
@endsection

@section('page-header')
  Dashboard
@endsection

@section('page-desc')
  Dashboard
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Role Detail</h3></div>
    <div class="box-body">
      <admin-role-view
        :role="{{$roleJson or '{}' }}"
        edit-url="{{route('admin.role.edit', ['id' => $role->id])}}"
        delete-url="{{route('admin.role.destroy', ['id' => $role->id])}}"
        redirect-url="{{route('admin.role.index')}}"
        ></admin-role-view>
    </div>
</div>
@endsection
