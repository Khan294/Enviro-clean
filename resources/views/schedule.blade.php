@extends('layouts.admin')

@section('style')
<style>
    .calendar{
        background-color: white;
        border: 1px solid #e1e1e1;
    }

    .calendar__week,
    .calendar__header {
      display: grid;
      grid-template-columns: repeat(7, 1fr);  
    }
    .calendar__week {
      grid-auto-rows: 150px;
    }

    .calendar__header {
      grid-auto-rows: 50px;
      align-items: center;
      text-align: center;
    }

    .calendar__day {
      padding: 2%;
      border-right: 1px solid #e1e1e1;
      border-top: 1px solid #e1e1e1;
      overflow-x: hidden;
      user-select: none;
    }

    .calendar__num {
      float: right;
      font-weight: bold;
      color:blue;
    }

    .calendar__slot{
      margin: 1%;
      overflow-x: hidden;
      overflow-y: scroll;
      max-height: 95%;
    }

    .calendar__header > div {
      text-transform: uppercase;
      font-size: 0.8em;
      font-weight: bold;
    }
    
    .calendar__day:last-child {
      border-right: 0;
    }
    ::-webkit-scrollbar {
      width: 0px;
    }

    .scrollable{
      
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"> Schedule </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Calendar
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="">
                  <div class="calendar__header">
                    <div>mon</div>
                    <div>tue</div>
                    <div>wed</div>
                    <div>thu</div>
                    <div>fri</div>
                    <div>sat</div>
                    <div>sun</div>
                  </div>
                  <div class="calendar__week">
                    <div class="calendar__day">
                      <div class="calendar__num"></div>
                      <div class="calendar__slot"></div>
                    </div>
                    
                    <div class="calendar__day">
                      <div class="calendar__num">2 </div>
                      <div class="calendar__slot scrollable">
                        <span class="label label-success">Allaho Chowk</span>
                        <span class="label label-success">Johar town</span>
                        <span class="label label-success">Link Road</span>
                      </div>
                    </div>
                    

                    <div class="calendar__day day">3</div>
                    <div class="calendar__day day">4</div>
                    <div class="calendar__day day">5</div>
                    <div class="calendar__day day">6</div> 
                    <div class="calendar__day day">7</div>
                  </div>
                  <div class="calendar__week">
                    <div class="calendar__day day">8</div>
                    <div class="calendar__day day">9</div>
                    <div class="calendar__day day">10</div>
                    <div class="calendar__day day">11</div>
                    <div class="calendar__day day">12</div>
                    <div class="calendar__day day">13</div>
                    <div class="calendar__day day">14</div>        
                  </div>
                  <div class="calendar__week">
                    <div class="calendar__day day">15</div>
                    <div class="calendar__day day">16</div>
                    <div class="calendar__day day">17</div>
                    <div class="calendar__day day">18</div>
                    <div class="calendar__day day">19</div>
                    <div class="calendar__day day">20</div>
                    <div class="calendar__day day">21</div>    
                  </div>
                  <div class="calendar__week">
                    <div class="calendar__day day">22</div>
                    <div class="calendar__day day">23</div>
                    <div class="calendar__day day">24</div>
                    <div class="calendar__day day">25</div>
                    <div class="calendar__day day">26</div> 
                    <div class="calendar__day day">27</div> 
                    <div class="calendar__day day">28</div> 
                  </div>
                  <div class="calendar__week">
                    <div class="calendar__day day">29</div>
                    <div class="calendar__day day">30</div>
                    <div class="calendar__day day">31</div>
                    <div class="calendar__day day">1</div>
                    <div class="calendar__day day">2</div>
                    <div class="calendar__day day">3</div>
                    <div class="calendar__day day">4</div>
                  </div>
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
        $( '.scrollable' ).on( 'mousewheel DOMMouseScroll', function ( e ) {
            var e0 = e.originalEvent,
                delta = e0.wheelDelta || -e0.detail;
            this.scrollTop += ( delta < 0 ? 1 : -1 ) * 10;
            e.preventDefault();
        });
    });
</script>

@endsection
