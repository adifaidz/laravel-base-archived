@extends('layouts.admin')

@section('title')
  Create Role
@endsection

@section('page-header')
  Role
@endsection

@section('page-desc')
  Create Role
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Create Role</h3></div>
    <div class="box-body">
      @include('admin.role.partial.form', ['route'=> route('admin.role.store'), 'method' => 'post'])
    </div>
    <div class="box-footer"></div>
</div>
@endsection
