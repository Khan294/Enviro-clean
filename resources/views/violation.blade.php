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
    div {word-break: break-all;}
    td {word-break: break-all;}
    .profilePic {float:right; width: 90%; height: 90%; margin-top: 7px;}
</style>
@endsection

@section('content')
<div ng-controller="violation">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header contentHeader"> Violation Report </h1>
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row">
      <div class="col-lg-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  Report
                  <a download="violations.json" class="btn btn-success" style="float:right; clear:none; position: relative" ng-href="[{ui.generateDownloadLink('json')}]"><i class="fa fa-database"></i> JSON</a>
                  <a download="violations.csv" class="btn btn-success" style="float:right; clear:none; position: relative" ng-href="[{ui.generateDownloadLink('csv')}]"><i class="fa fa-database"></i> CSV</a>
              </div>
              <!-- /.panel-heading -->
              <div class="panel-body">
                  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                      <thead>
                          <tr>
                              <th>Image</th>
                              <th>Valet</th>
                              <th>Infraction</th>
                              <th>Date</th>
                              <th>Fence</th>
                              <!--
                              <th>Region</th>
                              <th>Manager</th>
                              <th>Site</th>
                              <th>Status</th>
                              -->
                          </tr>
                      </thead>
                      <tbody>
                        <tr class="oneRow" ng-repeat="(header, value) in (inst.list.data)">
                          <td> <img id="violationImage" style="max-width: 100px; margin: auto" ng-click="ui.editRow(inst.list, $index)" ng-src="[{ui.fetchImage(value.image)}]"> </img> </td>
                          <td>[{(inst.lookUpUser.data | filter:{id:value.user_id}:true)[0].name}]</td>
                          <td>[{(inst.lookUpInfraction.data | filter:{id:value.infraction_id}:true)[0].infractionName}]</td>
                          <td>[{value.created_at}]</td>
                          <td>[{(inst.lookUpFence.data | filter:{id:value.fence_id}:true)[0].fenceName}]</td>
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
            <button class="btn" style="float:right" ng-click="ui.hideModal('#entryForm')"> <i class="fa fa-times"></i></button>
        </div>
        <div class="panel-body">
          <img style="width:100%" ng-src="[{ui.fetchImage(inst.temp.image)}]"> </img>
        </div>
    </div>
</div>
</div>
<!--
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Define Infractions
                <button class="btn btn-success" style="float:right;" onclick="document.getElementById('maButton').style.display='block'"><i class="fa fa-plus"></i></button>
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Priority</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <td>Trash out on non-collection day</td>
                            <td>3</td>
                        </tr>
                        <tr class="">
                            <td>Loose trash</td>
                            <td>1</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
-->

@endsection

@section('js')
<script type="text/javascript">
    app.controller('violation', function($scope, $http, Utility, Resource) {
      //$scope.base= Resource.base;
      $scope.inst= {temp:{}, list: {current:0, data:[]}, lookUpUser: {current:0, data:[]}, lookUpInfraction: {current:0, data:[]}, lookUpFence: {current:0, data:[]}};
      $scope.model= {
        primary: {id:null, user_id:"",  image:"", infraction_id:null, fence_id:null, created_at:""}
      };
      
      $scope.loader= function(){
        $scope.inst.temp= Utility.clone($scope.model.primary);
        Resource.api("violation", "get", null, null, function(res){
          console.log(res.data);
          $scope.inst.list.data= res.data;
        });
        Resource.api("user", "get", null, null, function(res){
          console.log(res.data);
          $scope.inst.lookUpUser.data= res.data;
        });
        Resource.api("infraction", "get", null, null, function(res){
          console.log(res.data);
          $scope.inst.lookUpInfraction.data= res.data;
        });
        Resource.api("fence", "get", null, null, function(res){
          console.log(res.data);
          $scope.inst.lookUpFence.data= res.data;
        });
      };

      $scope.ui= {
        isEdit: false,
        displayMessage: "",
        generateDownloadLink: function(format){
          if(format=="csv")
            return Resource.base + "downloadCsv";
          else if(format=="json")
            return Resource.base + "downloadJson";
        },
        hello: function(){
          alert("some");
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
                return Resource.base + "img/noPicture.png";
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
          if((issue= this.formValid(["id", "image", "password"])).length > 0) {
              this.showError("Not specified ["+ issue + " ]");
              console.log(issue);
              return;
          }

          this.hideModal("#entryForm");
          if($scope.inst.temp.id==null) {
              Resource.api("user", "create", $scope.inst.temp, $(tag).prop('files'), function(res){
                console.log(res);
                if(res.data.status=="pass"){
                    $scope.inst.temp.id= res.data.id;
                    list.data.push($scope.inst.temp);
                }
              });
          } else {
              Resource.api("user", "edit", $scope.inst.temp, $(tag).prop('files'), function(res){
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
            Resource.api("user", "delete", {id: id}, null, function(res){
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
