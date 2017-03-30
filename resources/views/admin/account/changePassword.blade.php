@extends('base::layouts.admin')

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
        <li class="active"><a href="{{route('admin.account.show', ['id'=> $user->id])}}">Account</a></li>
        <li><a href="{{route('admin.userprofile.show', ['id'=> $user->userprofile->id])}}">Profile</a></li>
      </ul>
      <div class="col-md-9">
        <form action="{{route('admin.account.save_password', ['id'=> $user->id])}}" method="post">
          <div class="form-group">
            <label for="name">Current</label>
            <input class="form-control" type="password" id="current_password" name="current_password" placeholder="Current Password">
          </div>
          <div class="form-group">
            <label for="name">New Password</label>
            <input class="form-control" type="password" id="password" name="password" placeholder="New Password">
          </div>
          <div class="form-group">
            <label for="name">Confirm Password</label>
            <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
          </div>
          {{csrf_field()}}
          {{ method_field('PUT') }}
          <input class="btn btn-primary" type="submit" name="submit" value="Save">
        </form>
      </div>
    </div>
  </div>
@endsection
