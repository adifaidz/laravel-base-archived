@extends('base::layouts.admin')

@section('title')
  Create User
@endsection

@section('page-header')
  User
@endsection

@section('page-desc')
  Create User
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Create User</h3></div>
    <div class="box-body">
      @include('base::admin.user.partial.form', ['route'=> route('admin.user.store'), 'method' => 'post'])
    </div>
    <div class="box-footer"></div>
</div>
@endsection
