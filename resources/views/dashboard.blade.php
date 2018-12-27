@extends('layouts.admin')

@section('style')
<style type="text/css">
  .navbar-static-top, .sidebar { z-index: 7}
</style>
@endsection

@section('content')
<div ng-controller="dashboard">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header contentHeader"> Dashboard </h1>
          No widgets yet
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row">
      <div class="col-lg-12">

      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
</div>
@endsection

@section('js')
  <script type="text/javascript">
    //app.controller('chat', function($scope, $http, Utility, Resource) { });
  </script>
@endsection
