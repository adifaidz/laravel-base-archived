@extends('base::layouts.admin')

@section('title')
  Edit User Account
@endsection

@section('page-header')
  Settings
@endsection

@section('page-desc')
  Edit User Account
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      <ul class="nav nav-pills nav-stacked col-md-3">
        <li class="active"><a href="{{route('admin.account.show', ['id'=> $user->id])}}">Account</a></li>
        <li><a href="{{route('admin.userprofile.show', ['id'=> $user->userprofile->id])}}">Profile</a></li>
      </ul>
      <div class="col-md-9">
        @include('base::admin.account.partial.form', ['route'=> route('admin.account.update',['id'=> $user->id]), 'method' => 'put'])
      </div>
    </div>
  </div>
@endsection
