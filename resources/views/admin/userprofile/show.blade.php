@extends('base::layouts.admin')

@section('title')
  Dasboard
@endsection

@section('head')
  <script>
    window.Laravel = { csrfToken: '{{ csrf_token() }}' };
  </script>
@endsection

@section('page-header')
  Dashboard
@endsection

@section('page-desc')
  Dashboard
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"> User Profile Detail</h3></div>
    <div class="box-body">
      <admin-userprofile-view
        :userprofile="{{$userprofileJson or '{}' }}"
        edit-url="{{route('admin.userprofile.edit', ['id' => $userprofile->id])}}"
        ></admin-userprofile-view>
    </div>
</div>
@endsection
