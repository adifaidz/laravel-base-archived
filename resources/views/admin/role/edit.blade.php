@extends('layouts.admin')

@section('title')
  Edit Role
@endsection

@section('page-header')
  Role
@endsection

@section('page-desc')
  Edit Role
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Edit Role</h3></div>
    <div class="box-body">
      @include('admin.role.partial.form', ['route'=> route('admin.role.update',['id'=> $role->id]), 'method' => 'put'])
    </div>
    <div class="box-footer"></div>
  </div>
@endsection
