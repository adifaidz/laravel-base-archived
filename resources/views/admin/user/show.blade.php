@extends('base::layouts.admin')

@section('title')
  Dasboard
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
        <h3 class="box-title">User Detail</h3></div>
    <div class="box-body">
      <admin-user-view
        :user="{{$userJson or '{}' }}"
        edit-url="{{route('admin.user.edit', ['id' => $user->id])}}"
        delete-url="{{route('admin.user.destroy', ['id' => $user->id])}}"
        redirect-url="{{route('admin.user.index')}}"
        ></admin-user-view>
    </div>
</div>
@endsection
