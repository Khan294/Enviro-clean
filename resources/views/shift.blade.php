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
      grid-auto-rows: 110px;
    }

    .calendar__header {
      grid-auto-rows: 50px;
      align-items: center;
      text-align: center;
    }

    .calendar__day {
      padding: 2%;
      /*border-right: 1px solid #e1e1e1;*/
      border-top: 1px solid #e1e1e1;
      overflow-x: hidden;
      user-select: none;
    }

    .calendar__day:last-child {
      border-right: 0;
    }

    .active__calendar__day:hover {
      border: 2px solid #2f4f4f;
    }

    .calendar__num {
      float: right;
      right: 1px;
      font-weight: bold;
      color:#2F4F4F;
      font-size: 1.2em;
      position: absolute;
    }

    .calendar__slot{
      margin: 1%;
      overflow-x: hidden;
      overflow-y: scroll;
      max-height: 95%;
    }

    .calendar__header > div {
      text-transform: uppercase;
      font-size: 1.2em;
      font-weight: bold;
    }

    ::-webkit-scrollbar {
      width: 0px;
    }
    /*  background: red; */
    .siteCard {  border-radius: 7px; padding:5px; color:white; clear:both; width:90%; margin-bottom: 3px; font-size:0.7em;} /*border: 1px solid #403D3D;*/
    .siteNormal{float:left; background: teal} /*#808080b5*/

    /*.siteCreate{background-size: 50% 70%; background-repeat: no-repeat; background-position: center; background-image: url({{ asset("img/createSimple.png") }});} */

    .expand{height: 99%; width: 99%; margin: auto;}
    .blankSiteCard{border-radiuas: 7px; padding:5px; color:black; clear:both; margin-bottom: 3px; float:left; background:green;} /* background-size: 50% 50%; background-repeat: no-repeat; background-position: center; background-image: url({{ asset("img/addItem.png") }})*/

    .panel-heading {overflow:hidden ;}
    .btn{padding:1px 5px !important; outline:none; margin: 1px}
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
    label {margin-top: 7px;}
    div {word-break: break-all;}
    .profilePic {float:right; width: 90%; height: 90%; margin-top: 7px;}
    table td {word-break: break-all;}
    .myAlert-bottom{position: fixed; bottom: 5px; left:2%; width: 96%; z-index: 14}
    .hoverable:hover {color: red;}
    .hoverable {color: green;}
</style>
@endsection

@section('content')
<div ng-controller="shift">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header contentHeader"> Schedule </h1>
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row">
      <div class="col-lg-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                <div style="text-align: center; font-size: 1.5em"> <b>[{cal.monName}], [{cal.year}] </b></div>
                <br/>
                <div style="width:50%; display:inline-flex">
                  <select class="form-control" title="Select month." style="width:30%; padding: 5px; max-width:140px" ng-model="cal.selectedMonth">
                    <option class="expand" ng-repeat="(header, value) in (cal.monthNames)" ng-value="$index">[{value}]</option>
                  </select>
                  <input style="margin-left:5px; width:25%; padding: 5px; max-width:70px" class="form-control" type="number" min="2018" ng-value="cal.selectedYear">
                  <button class="btn" style="margin-left:5px;"> <i class="fa fa-search"></i></button>
                </div>
                <div style="float:right;width:50%; display:flex;">
                  <select class="form-control" title="You can select a region from here." ng-model="inst.regionLookUp.current" ng-change="ui.updateRegion()">
                      <option class="expand" ng-repeat="(header, value) in (inst.regionLookUp.data)" ng-value="value.id">[{value.regionName}]</option>
                  </select>
                  <select ng-disabled="inst.lookUp.current<0" class="form-control" style="margin-left:10px" title="You can select a valet from here." ng-model="inst.lookUp.current" ng-change="ui.updateCalendar()">
                      <option class="expand" ng-repeat="(header, value) in (inst.lookUp.data)" ng-value="value.id">[{value.name}]</option>
                  </select>
                </div>
              </div>
              <!-- /.panel-heading -->
              <div class="panel-body" ng-hide="inst.lookUp.current<0">
                  <div class="">
                    <div class="calendar__header">
                      <div>sun</div>
                      <div>mon</div>
                      <div>tue</div>
                      <div>wed</div>
                      <div>thu</div>
                      <div>fri</div>
                      <div>sat</div>
                    </div>
                    <div ng-repeat="calRow in [] | range:6" class="calendar__week">
                      <div ng-repeat="calCol in [] | range:7" ng-init="day= calRow*7 + calCol+1 - cal.miss" class="calendar__day" ng-class="(day<=cal.max && day>0)?'active__calendar__day scrollable': ''">
                        <div ng-if="day<=cal.max && day>0" class="expand" ng-init="tag=cal.year+'-'+cal.mon+'-'+day; ">
                          <div style="position:relative" ng-click="ui.entry(inst.list, tag)" class= "expand">
                            <div class="calendar__slot expand" ng-if="cal.shifts[tag]!==undefined">
                              <div class="calendar__num" ng-style="cal.today==day && {'color':'red'}"> [{day}] </div>
                              <div class="" ng-repeat="(header, value) in (inst.list.data[cal.shifts[tag]].binds)">
                                <!-- <span class="siteCard siteNormal"> [{inst.lookUp1.data[value-1].siteName}]</span> -->
                                <span class="siteCard siteNormal"> [{ui.fetchSiteData(value)}]</span>
                              </div>
                            </div>
                            <div class="calendar__slot expand siteCreate" ng-if="cal.shifts[tag]===undefined">
                              <div class="calendar__num" ng-style="cal.today==day && {'color':'red'}">[{day}]<br/><span style="float:right" class="fa fa-plus hoverable"></span></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> <!--week loop-->
                  </div>
              </div>
              <!-- /.panel-body -->
          </div>
          <!-- /.panel -->
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->

  <div id="entryForm" class="fhk-modal">
      <div class="panel panel-default fhk-modal-container">
          <div class="panel-heading">
              <b>[{ui.isEdit? "Edit": "Add"}] Shift</b>
              <button class="btn" style="float:right" ng-click="ui.hideModal('#entryForm')"> <i class="fa fa-times"></i></button>
          </div>
          <div class="panel-body">
              <div style="width:100%">
                  <label>Time</label> <input class="form-control" type="time" ng-model="inst.temp.timTag" date-format>
                  <label>Job Site </label>
                  <select class="form-control" title="Select multiple sites for a shift." ng-model="inst.temp.binds" multiple="">
                      <option class="expand" ng-repeat="(header, value) in (inst.lookUp1.data)" ng-value="value.id">[{value.siteName}]</option>
                  </select>
              </div>

              <div style="width:30%; float:right; display:inline-block;margin:7px">
                  <button class="btn" style="float:right; clear:none;" ng-click="ui.sendData(inst.list, null)">[{ui.isEdit? "Edit": "Add"}]</button> 
                  <span ng-if="ui.isEdit">
                  <button class="btn" style="float:right; clear:none;" ng-click="ui.deleteItem(inst.list, inst.list.current)">Remove</button>
                </span> 
              </div>
          </div>
      </div>
  </div> <!--row-->
  <div id="deleteForm" class="fhk-modal">
        <div class="panel panel-default fhk-modal-container">
            <div class="panel-heading">
                <b>Delete</b>
                <button class="btn" style="float:right" ng-click="ui.hideModal('#deleteForm')"> <i class="fa fa-times"></i></button>
            </div>
            <div class="panel-body">
                Are you sure you want to delete this item?
                <br/>
                <div style="float:right; display:inline-block;">
                    <button class="btn" style="float:right; clear:none;" ng-click="ui.hideModal('#deleteForm')">No</button>
                    <button class="btn" style="float:right; clear:none; color:red" ng-click="ui.deleteData(inst.list)">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <div id="displayMessage" class="alert alert-warning alert-dismissible myAlert-bottom collapse">
      <a href="#" class="close" ng-click="ui.hideModal('#displayMessage')">&times;</a>
      <strong>Issues:</strong> <br/> <span ng-bind-html="ui.displayMessage"></span>
    </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<!-- DataTables JavaScript -->
<script type="text/javascript">
    $(document).ready(function() {
        $( '.scrollable' ).on( 'mousewheel DOMMouseScroll', function ( e ) {
            var e0 = e.originalEvent,
                delta = e0.wheelDelta || -e0.detail;
            this.scrollTop += ( delta < 0 ? 1 : -1 ) * 10;
            e.preventDefault();
        });
    });
 
    app.controller('shift', function($scope, $http, Resource, Utility, $timeout) {
      $scope.cal= {max:30, miss:4, mon:0, year:0};
     $scope.inst= {temp:{}, list: {current:0, data:[]}, lookUp: {current:0, data:[]}, lookUp1: {current:0, data:[]}, regionLookUp: {current:0, data:[]}};
      $scope.model= {
        primary: {id:null, dateTag:"",  timTag:"10:00:00", user_id:"", binds: []}
      };

      $scope.loader= function(){
        var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        var date = new Date(), y = date.getFullYear(), m = date.getMonth();
        var firstDay = new Date(y, m, 1);
        var lastDay = new Date(y, m + 1, 0);

        $scope.cal.monthNames= monthNames;
        $scope.cal.year= y;
        $scope.cal.mon= m+1;
        $scope.cal.monName= monthNames[date.getMonth()];
        $scope.cal.max= lastDay.getDate();
        $scope.cal.today= date.getDate()
        $scope.cal.miss= firstDay.getDay();
        $scope.cal.shifts= {};
        $scope.cal.selectedMonth= m;
        $scope.cal.selectedYear= y;

        Resource.api("region", "get", null, null, function(res){
            $scope.ui.initList($scope.inst.regionLookUp, res.data);
            $scope.ui.updateValet();
            $scope.ui.updateSites();
        });

        $scope.inst.temp= Utility.clone($scope.model.primary);
      };

      $scope.ui= {
        isEdit: false,
        displayMessage: "",
        initList: function(list, newDat){
          if(newDat==null || newDat==undefined) {
            list.current= -1;
            list.data= {};
            return;
          } else if(newDat.length<1) {
            list.current= -1;
            list.data= {};
            console.log("EMPTY");
            return;
          }
          list.data= newDat; list.current= list.data[0].id;
        },
        updateSites: function() {
          Resource.api("sitebyregion/" + $scope.inst.regionLookUp.current, "get", null, null, function(res) {
            $scope.ui.initList($scope.inst.lookUp1, res.data);
            console.log($scope.inst.lookUp1);
          });
        },
        updateValet: function() {
          Resource.api("userbyregion/" + $scope.inst.regionLookUp.current, "get", null, null, function(res){
            $scope.ui.initList($scope.inst.lookUp, res.data);
            $scope.ui.updateCalendar();
            console.log($scope.inst.lookUp);
          });          
        },
        updateRegion:function() { 
          $scope.ui.updateValet();
          $scope.ui.updateSites();
        },
        updateCalendar: function() {
          $scope.cal.shifts= {};
          Resource.api("shift", "show", {id:$scope.inst.lookUp.current}, null, function(res) {
            res.data.forEach(function(item, index) {
              item.binds= [];
              item.sites.forEach(function(bind, idx){
                item.binds.push(bind.id);
              });
              $scope.cal.shifts[item.dateTag]= index;
            });
            console.log(res.data);
            $scope.inst.list.data= res.data;
          });
        },
        showError(message){
            this.displayMessage= message;
            $("#displayMessage").show();
        },
        formValid: function(exempt){
            err= "";
            Object.keys($scope.inst.temp).forEach(function(key){ 
                if(exempt.indexOf(key) < 0 && $scope.inst.temp[key]=="")
                    err += key + ", ";
            });
            return err;
        },
        fetchImage: function(img) {
            if(!img) {
                return Resource.base + "img/placeholder.png";
            } else
                return Resource.base + img;
        },
        entry: function(list, dateTag) {
          idx= $scope.cal.shifts[dateTag];
          if(idx!=undefined && idx!=null)
            this.editRow(list, idx);
          else
            this.addRow(dateTag);
        },
        editRow: function(list, idx) {
          this.isEdit= true;
          list.current= idx;
          $scope.inst.temp= list.data[idx];
          $('#entryForm').show();
        },
        addRow: function(dateTag) {
          this.isEdit= false;
          $scope.inst.temp= Utility.clone($scope.model.primary);
          $scope.inst.temp.user_id= $scope.inst.lookUp.current;
          $scope.inst.temp.dateTag= dateTag;
          $('#entryForm').show();
        },
        deleteItem: function(list, idx) {
          list.current= idx;
          $('#deleteForm').show();
        },
        //hide any modal
        hideModal: function(nam){
          $(nam).hide();
        },
        //add or edit active data
        sendData: function(list, tag){
          console.log($scope.cal.shifts);
          if((issue= this.formValid(["id", "binds", "sites"])).length > 0) {
              this.showError("Not specified ["+ issue + " ]");
              console.log(issue);
              return;
          }
          //return;

          this.hideModal("#entryForm");
          if($scope.inst.temp.id==null) {
              Resource.api("shift", "create", $scope.inst.temp, $(tag).prop('files'), function(res){
                console.log(res.data);
                if(res.data.status=="pass"){
                    $scope.inst.temp.id= res.data.id;
                    $scope.cal.shifts[$scope.inst.temp.dateTag]= list.data.push($scope.inst.temp)-1;
                    console.log($scope.inst.temp);
                    console.log($scope.cal.shifts);
                    //$timeout(function() {$scope.$digest();});
                    //$scope.$applyAsync();
                    //update calendar shifts array
                    //
                }
              });
          } else {
              Resource.api("shift", "edit", $scope.inst.temp, $(tag).prop('files'), function(res){
                console.log(res);
                if(res.data.status=="pass"){
                    list.data[list.current].image= res.data.image;
                }
              });
          }
        },
        //resource call to delete active item
        deleteData: function(list) {
            this.hideModal("#deleteForm");
            this.hideModal("#entryForm");

            id= list.data[list.current].id;

            Resource.api("shift", "delete", {id: id}, null, function(res){
                if(res.data.status=="pass"){
                  $scope.ui.updateCalendar();
                }
            });
        },
        //placed on file input, updates live preview
        updateImage(input, tag) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(tag).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        },
        fetchSiteData(idx) {
          if($scope.inst.lookUp1.data.length>0)
            return $scope.inst.lookUp1.data.filter(x => x.id == idx)[0].siteName;
        }
      };
      $scope.loader();
    });
</script>

@endsection
