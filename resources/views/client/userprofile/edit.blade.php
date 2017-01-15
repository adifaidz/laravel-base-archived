@extends('base::layouts.client')

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
      @include('base::client.userprofile.partial.form', ['route'=> route('client.userprofile.update',['id'=> $userprofile->id]), 'method' => 'put'])
    </div>
    <div class="box-footer"></div>
  </div>
@endsection
