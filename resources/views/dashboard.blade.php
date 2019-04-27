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
          <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d1372.4978134345222!2d-80.89363063813646!3d35.09751248883776!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1senviro+clean+Pineville%2C+NC+28134!5e0!3m2!1sen!2s!4v1553335968486" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
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
