@extends('base::layouts.admin')

@section('title')
  Edit User Profile
@endsection

@section('page-header')
  Settings
@endsection

@section('page-desc')
  Edit User Profile
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      <ul class="nav nav-pills nav-stacked col-md-3">
        <li><a href="{{route('admin.account.show', ['id'=> $userprofile->user->id])}}">Account</a></li>
        <li class="active"><a href="{{route('admin.userprofile.show', ['id'=> $userprofile->id])}}">Profile</a></li>
      </ul>
      <div class="col-md-9">
        @include('base::admin.userprofile.partial.form', ['route'=> route('admin.userprofile.update',['id'=> $userprofile->id]), 'method' => 'put'])
      </div>
    </div>
  </div>
@endsection
