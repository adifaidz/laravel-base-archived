@extends('base::layouts.admin')

@section('title')
  Edit Permission
@endsection

@section('page-header')
  Permission
@endsection

@section('page-desc')
  Edit Permission
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Edit Permission</h3></div>
    <div class="box-body">
      @include('base::admin.permission.partial.form', ['route'=> route('admin.permission.update',['id'=> $permission->id]), 'method' => 'put'])
    </div>
    <div class="box-footer"></div>
  </div>
@endsection
