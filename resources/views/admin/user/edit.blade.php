@extends('layouts.admin')

@section('title')
  Edit User
@endsection

@section('page-header')
  User
@endsection

@section('page-desc')
  Edit User
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Edit User</h3></div>
    <div class="box-body">
      @include('admin.user.partial.form', ['route'=> route('admin.user.update',['id'=> $user->id]), 'method' => 'put'])
    </div>
    <div class="box-footer"></div>
  </div>
@endsection
