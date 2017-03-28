@extends('base::layouts.client')

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
        <li class="active"><a href="{{route('client.account.show', ['id'=> $user->id])}}">Account</a></li>
        <li><a href="{{route('client.userprofile.show', ['id'=> $user->userprofile->id])}}">Profile</a></li>
      </ul>
      <div class="col-md-9">
        @include('base::client.account.partial.form', ['route'=> route('client.account.update',['id'=> $user->id]), 'method' => 'put'])
      </div>
    </div>
  </div>
@endsection
