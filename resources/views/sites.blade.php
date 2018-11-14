@extends('layouts.admin')

@section('content')
<!-- //https://codepen.io/SarasArya/pen/GoLWQR -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"> Manage Site </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Sites
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Region</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Proximity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <td>Allahu chowk</td>
                            <td>Johar Town</td>
                            <td>31.4693215</td>
                            <td>74.2968606</td>
                            <td>70m</td>
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
