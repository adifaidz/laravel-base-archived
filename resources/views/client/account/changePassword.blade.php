@extends('base::layouts.client')

@section('title')
  Change Password
@endsection

@section('page-header')
  Settings
@endsection

@section('page-desc')
  Change Password
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      <ul class="nav nav-pills nav-stacked col-md-3">
        <li class="active"><a href="{{route('client.account.show', ['id'=> $user->id])}}">Account</a></li>
        <li><a href="{{route('client.userprofile.show', ['id'=> $user->userprofile->id])}}">Profile</a></li>
      </ul>
      <div class="col-md-9">
        <form action="{{route('client.account.save_password', ['id'=> $user->id])}}" method="post">
          <div class="form-group">
            <label for="name">Current</label>
            <input class="form-control" type="password" id="current-password" name="current-password" placeholder="Current Password">
          </div>
          <div class="form-group">
            <label for="name">New Password</label>
            <input class="form-control" type="password" id="password" name="password" placeholder="New Password">
          </div>
          <div class="form-group">
            <label for="name">Confirm Password</label>
            <input class="form-control" type="password" id="password-confirmation" name="password-confirmation" placeholder="Confirm Password">
          </div>
          {{csrf_field()}}
          {{ method_field('PUT') }}
        </form>
      </div>
    </div>
  </div>
@endsection
