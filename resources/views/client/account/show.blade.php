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
        <li class="active"><a href="{{route('client.account.show', ['id'=> $user->id])}}">Account</a></li>
        <li><a href="{{route('client.userprofile.show', ['id'=> $user->userprofile->id])}}">Profile</a></li>
      </ul>
      <div class="col-md-9">
        <client-userprofile-view
          :userprofile="{{$userprofileJson or '{}' }}"
          edit-url="{{route('client.account.edit', ['id' => $user->id])}}"
          ></client-userprofile-view>
      </div>
    </div>
  </div>
@endsection
