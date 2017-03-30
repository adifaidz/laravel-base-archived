@extends('base::layouts.admin')

@section('title')
  User Account
@endsection

@section('page-header')
  Settings
@endsection

@section('page-desc')
  User Account
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      <ul class="nav nav-pills nav-stacked col-md-3">
        <li class="active"><a href="{{route('admin.account.show', $user)}}">Account</a></li>
        <li><a href="{{route('admin.userprofile.show', $user->userprofile)}}">Profile</a></li>
      </ul>
      <div class="col-md-9">
        <admin-account-view
          :user="{{$user or '{}' }}"
          edit-url="{{route('admin.account.edit', $user)}}"
          change-password-url="{{route('admin.account.change_password', $user)}}"
          ></admin-account-view>
      </div>
    </div>
  </div>
@endsection
