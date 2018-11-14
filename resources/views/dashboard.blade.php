@extends('layouts.admin')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"> Dashboard </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Violations
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Region</th>
                            <th>Manager</th>
                            <th>Site</th>
                            <th>Valet</th>
                            <th>Date</th>
                            <th>Building</th>
                            <th>Priority</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <td>Johar Town</td>
                            <td>Fahad Khan</td>
                            <td>Allahu chowk</td>
                            <td>Jasir Javed</td>
                            <td class="center"> 2018-11-9 </td>
                            <td class="center"> 159-B </td>
                            <td> 1 </td>
                            <td>Active</td>
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
