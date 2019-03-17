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
    label {margin-top: 7px;}
    ::-webkit-scrollbar {
      width: 0px;
    }
    .profilePic {float:right; width: 90%; height: 90%; margin-top: 7px;}
    .myAlert-bottom{position: fixed; bottom: 5px; left:2%; width: 96%; z-index: 14}
</style>
@endsection

@section('content')
<div ng-controller="region">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header contentHeader"> Manage Regions </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Regions
                    <button class="btn btn-success" style="float:right;" ng-click="ui.addRow()"><i class="fa fa-plus"></i></button>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th style="width:30px;"><i class="fa fa-cog"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="oneRow" ng-repeat="(header, value) in (inst.list.data)">
                                <td>[{value.regionName}]</td>
                                <td> <span style="float:right;"> <i class="fa fa-edit" style="color:blue" ng-click="ui.editRow(inst.list, $index);"></i><i class="fa fa-trash" style="color:red" ng-click="ui.deleteItem(inst.list, $index)";></i> </span>
                                </td>
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
    <div id="entryForm" class="fhk-modal">
        <div class="panel panel-default fhk-modal-container">
            <div class="panel-heading">
                <b>[{ui.isEdit? "Edit": "Add"}] Region</b>
                <button class="btn" style="float:right" ng-click="ui.hideModal('#entryForm')"> <i class="fa fa-times"></i></button>
            </div>
            <div class="panel-body">
                <div style="width:100%">
                    <label>Name</label> <input class="form-control" type="text" ng-model="inst.temp.regionName">
                </div>

                <div style="width:30%; float:right; display:inline-block;">
                  </br>
                  <button class="btn" style="float:right; clear:none;" ng-click="ui.sendData(inst.list, null)">[{ui.isEdit? "Save": "Add"}]</button> 
                </div>
            </div>
        </div>
    </div>
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
@endsection

@section('js')
<script type="text/javascript">
    app.controller('region', function($scope, $http, Utility, Resource) {
      //$scope.base= Resource.base;
      $scope.inst= {temp:{}, list: {current:0, data:[]}, lookUp: {current:0, data:[]}};
      $scope.model= {
        primary: {id:null, regionName:""}
      };
      
      $scope.loader= function(){
        $scope.inst.temp= Utility.clone($scope.model.primary);
        Resource.api("region", "get", null, null, function(res){
          //res.data.forEach(function(item){ });
          $scope.inst.list.data= res.data;
        });
      };

      $scope.ui= {
        isEdit: false,
        displayMessage: "",
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
        editRow: function(list, idx) {
          this.isEdit= true;
          list.current= idx;
          $scope.inst.temp= list.data[idx];
          $('#entryForm').show();
        },
        addRow: function() {
          this.isEdit= false;
          $scope.inst.temp= Utility.clone($scope.model.primary);
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
          if((issue= this.formValid(["id"])).length > 0) {
              this.showError("Not specified ["+ issue +" ]");
              console.log(issue);
              return;
          }
          files= tag? $(tag).prop('files'): null;
          this.hideModal("#entryForm");

          if($scope.inst.temp.id==null) {
              Resource.api("region", "create", $scope.inst.temp, files, function(res){
                console.log(res);
                if(res.data.status=="pass"){
                    $scope.inst.temp.id= res.data.id;
                    list.data.push($scope.inst.temp);
                }
              });
          } else {
              Resource.api("region", "edit", $scope.inst.temp, files, function(res){
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
            id= list.data[list.current].id;
            Resource.api("region", "delete", {id: id}, null, function(res){
                if(res.data.status=="pass"){
                    list.data.splice(list.current,1);
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
        }
      };
      $scope.loader();
    });
</script>
@endsection
