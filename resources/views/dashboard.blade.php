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
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2926.8236245230028!2d-86.06064558452931!3d42.813213079159134!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x85a8b0679340f0d3!2sEnviro-Clean+Services%2C+Inc.!5e0!3m2!1sen!2s!4v1550437461728" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
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
