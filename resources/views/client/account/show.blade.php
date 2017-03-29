@extends('base::layouts.client')

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
        <li class="active"><a href="{{route('client.account.show', $user)}}">Account</a></li>
        <li><a href="{{route('client.userprofile.show', $user->userprofile)}}">Profile</a></li>
      </ul>
      <div class="col-md-9">
        <client-account-view
          :user="{{$user or '{}' }}"
          edit-url="{{route('client.account.edit', $user)}}"
          change-password-url="{{route('client.account.change_password', $user)}}"
          ></client-account-view>
      </div>
    </div>
  </div>
@endsection
