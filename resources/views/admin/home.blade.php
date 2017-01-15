@extends('base::layouts.admin')

@section('title')
  Dasboard
@endsection

@section('page-header')
  Dashboard
@endsection

@section('page-desc')
  Dashboard
@endsection

@section('content')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="box box-primary">

        <div class="box-header with-border">
          Site List
        </div>

        <div class="box-body no-padding">
          <table class="table table-bordered table-hover table-responsive no-padding">
            <tbody><tr>
              <th>ID</th>
              <th>User</th>
              <th>Date</th>
              <th>Status</th>
              <th>Reason</th>
            </tr>
            <tr>
              <td>183</td>
              <td>John Doe</td>
              <td>11-7-2014</td>
              <td><span class="label label-success">Approved</span></td>
              <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            <tr>
              <td>219</td>
              <td>Alexander Pierce</td>
              <td>11-7-2014</td>
              <td><span class="label label-warning">Pending</span></td>
              <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            <tr>
              <td>657</td>
              <td>Bob Doe</td>
              <td>11-7-2014</td>
              <td><span class="label label-primary">Approved</span></td>
              <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
            <tr>
              <td>175</td>
              <td>Mike Doe</td>
              <td>11-7-2014</td>
              <td><span class="label label-danger">Denied</span></td>
              <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
            </tr>
          </tbody></table>
        </div>
      </div>
    </div>
  </div>
@endsection
