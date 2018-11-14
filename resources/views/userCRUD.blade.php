@extends('layouts.admin')

@section('style')
<style type="text/css">
    .panel-heading {overflow:hidden ;}
    .btn{padding:1px 5px !important; clear:both; outline:none; margin: 1px}
    .fhk-modal {
        z-index: 13; display: none; padding-top: 100px;
        position: fixed; overflow: auto;
        left: 0; top: 0; width: 100%; height: 100%; 
        background-color: rgba(0,0,0,0.4);}
    .fhk-modal-container {
        width:50%;
        margin: auto;
    }
    .navbar-static-top, .sidebar { z-index: 7}
    .profilePic {float:right; width: 90%; height: 90%; margin-top: 7px;}
    label {margin-top: 7px;}
    ::-webkit-scrollbar {
      width: 0px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Manager users</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Basic details
                <button class="btn btn-success" style="float:right;" onclick="document.getElementById('maButton').style.display='block'"><i class="fa fa-plus"></i></button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Authority</th>
                            <th>Wages</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <td>Fahad</td>
                            <td>example1@someSite.com</td>
                            <td>0300-1234567</td>
                            <td class="center"> Super </td>
                            <td class="center"> - </td>
                        </tr>
                        <tr class="">
                            <td>Waleed</td>
                            <td>example2@someSite.com</td>
                            <td>0300-1234567</td>
                            <td class="center"> Manager </td>
                            <td class="center"> 30$/hr </td>
                        </tr>
                        <tr class="">
                            <td>Umer</td>
                            <td>example3@someSite.com</td>
                            <td>0300-1234567</td>
                            <td class="center"> Valet </td>
                            <td class="center"> 15$/hr</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div id="maButton" class="fhk-modal">
    <div class="panel panel-default fhk-modal-container">
        <div class="panel-heading">
            <b>Add User</b>
            <button class="btn" style="float:right" onclick="document.getElementById('maButton').style.display='none'"> <i class="fa fa-times"></i></button>
        </div>
        <div class="panel-body">
            <div style="width:30%; float:right"><img class="profilePic" src="{{asset('img/placeholder.png')}}"> </img></div>

            <div style="width:70%">
                <label>Name</label> <input class="form-control" type="text">
                <label>Email</label> <input class="form-control" type="text">
                <label>Contact</label> <input class="form-control" type="text">
                <label>Authority</label> <select class="form-control">
                    <option>Super</option>
                    <option>Manager</option>
                    <option>Valet</option>
                </select>
                <label>Wage</label> <input class="form-control" type="text">
            </div>

            <div style="width:30%; float:right; display:inline-block;">
                <button class="btn" style="float:right; clear:none;">Add</button>
                <button class="btn" style="float:right; clear:none;">Remove</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- DataTables JavaScript -->
<script src=" {{ asset('vendor/datatables/js/jquery.dataTables.min.js') }} "></script>
<script src=" {{ asset('vendor/datatables-plugins/dataTables.bootstrap.min.js') }} "></script>
<script src=" {{ asset('vendor/datatables-responsive/dataTables.responsive.js') }} "></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({responsive: true});
        $('#dataTables-example_filter').css('float','right');
    });    
</script>

<script>
var app = angular.module('myApp', []);
app.controller('myController', function($scope, $http) {

});
@endsection
