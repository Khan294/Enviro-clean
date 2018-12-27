@extends('layouts.onePage')

@section('style')
<style type="text/css">
    .panel {margin:0px; height:100vh; width: 100%; position: absolute; overflow-y:scroll}
    .errspan {float: right; margin-right: 6px; margin-top: -25px; position: relative; z-index: 2; color: green;}
    .chatCard {background: red; border-radius: 7px; padding:5px; color:white; clear:both; width:70%; margin-bottom: 7px;}
    .otherPerson{float:left;   background: grey;}
    .person{float:right; background: green;}
    ::-webkit-scrollbar {
      width: 0px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <!--
    <a href="{{ url('login') }}" style="color:green; float:right; margin:7px 7px"> <i class="fa fa-sign-in" style="font-size:36px;"></i></a> -->
    <div class="col-lg-12">
        <!-- <h1 class="page-header"> Violations </h1> -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class=""> <!--col-lg-12-->
        <div class="panel panel-default">
            <div class="panel-heading">
                Managers
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div style="overflow-y: scroll; height:73vh;">
                    
                    <span class="chatCard otherPerson">Hello, John. How are you?</span>

                    <span class="chatCard person">I am just fine. And how are you, Martha?</span>

                    <span class="chatCard otherPerson">My job search is going rather slowly, I'm afraid. Are you still working at Smith and Sons?</span>
                    <span class="chatCard otherPerson">Hello, John. How are you?</span>

                    <span class="chatCard person">I am just fine. And how are you, Martha?</span>

                    <span class="chatCard otherPerson">My job search is going rather slowly, I'm afraid. Are you still working at Smith and Sons?</span>
                    <span class="chatCard otherPerson">Hello, John. How are you?</span>

                    <span class="chatCard person">I am just fine. And how are you, Martha?</span>

                    <span class="chatCard otherPerson">My job search is going rather slowly, I'm afraid. Are you still working at Smith and Sons?</span>
                    <!-- -->
                </div>
                <div>
                    <input class="form-control" type="text">
                    <span class="fa fa-paper-plane errspan"></span>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

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
@endsection
