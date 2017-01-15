@extends('base::layouts.admin')

@section('title')
  Create Permission
@endsection

@section('page-header')
  Permission
@endsection

@section('page-desc')
  Create Permission
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Create Permission</h3></div>
    <div class="box-body">
      @include('base::admin.permission.partial.form', ['route'=> route('admin.permission.store'), 'method' => 'post'])
    </div>
    <div class="box-footer"></div>
</div>
@endsection
