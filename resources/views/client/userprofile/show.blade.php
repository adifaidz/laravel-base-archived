@extends('base::layouts.client')

@section('title')
  User Profile
@endsection

@section('page-header')
  Settings
@endsection

@section('page-desc')
  User Profile
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      <ul class="nav nav-pills nav-stacked col-md-3">
        <li><a href="{{route('client.account.show', $userprofile->user)}}">Account</a></li>
        <li class="active"><a href="{{route('client.userprofile.show', $userprofile)}}">Profile</a></li>
      </ul>
      <div class="col-md-9">
        <client-userprofile-view
          :userprofile="{{$userprofileJson or '{}' }}"
          edit-url="{{route('client.userprofile.edit', $userprofile)}}"
          ></client-userprofile-view>
      </div>
    </div>
  </div>
@endsection
