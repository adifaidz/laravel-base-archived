@extends('base::layouts.admin')

@section('title')
  Edit  User Profile
@endsection

@section('page-header')
   User Profile
@endsection

@section('page-desc')
  Edit  User Profile
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Edit  User Profile</h3></div>
    <div class="box-body">
      @include('base::admin.userprofile.partial.form', ['route'=> route('admin.userprofile.update',['id'=> $userprofile->id]), 'method' => 'put'])
    </div>
    <div class="box-footer"></div>
  </div>
@endsection
