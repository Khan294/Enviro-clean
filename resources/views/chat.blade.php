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
    i:hover {color:green;}
    .myAlert-bottom{position: fixed; bottom: 5px; left:2%; width: 96%; z-index: 14}
</style>
@endsection

@section('content')
<div ng-controller="chat">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header contentHeader"> Messenger </h1>
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row">
      <div class="col-lg-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  Chats
                  <button class="btn btn-success" style="float:right;" ng-click="ui.addRow()"><i class="fa fa-plus"></i></button>
              </div>
              <!-- /.panel-heading -->
              <div class="panel-body">
                  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                      <thead>
                          <tr>
                              <th>Chats</th>
                          </tr>
                      </thead>
                      <tbody>
                        <tr class="oneRow" ng-repeat="(header, value) in (inst.list.data)">
                          <td>[{value.chatName}]
                          <span style="float:right;"> <i ng-click="ui.editRow(inst.list, $index);" class="fa fa-edit fa-fw"></i><i onclick="openchat()" class="fa fa-comments fa-fw"></i> </span></td>
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
              <b>[{ui.isEdit? "Edit": "Add"}] Group</b>
              <button class="btn" style="float:right" ng-click="ui.hideModal('#entryForm')"> <i class="fa fa-times"></i></button>
          </div>
          <div class="panel-body">
              <div style="width:100%">
                  <label>Group name</label> <input class="form-control" type="text" ng-model="inst.temp.chatName">
                  <label>Users </label> <select class="form-control" title="Select multiple users for a shift." ng-model="inst.temp.binds" multiple="">
                      <option class="expand" ng-repeat="(header, value) in (inst.lookUp.data)" ng-value="value.id">[{value.name}]</option>
                  </select>
              </div>

              <div style="width:30%; float:right; display:inline-block; margin:7px">
                  <button class="btn" style="float:right; clear:none;" ng-click="ui.sendData(inst.list, '#image')">[{ui.isEdit? "Save": "Add"}]</button>
                  <span ng-if="ui.isEdit">
                  <button class="btn" style="float:right; clear:none;" ng-click="ui.deleteItem(inst.list, inst.list.current);">Remove</button>
                  </span>
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
  <!-- DataTables JavaScript 
  <script src=" {{ asset('vendor/datatables/js/jquery.dataTables.min.js') }} "></script>
  <script src=" {{ asset('vendor/datatables-plugins/dataTables.bootstrap.min.js') }} "></script>
  <script src=" {{ asset('vendor/datatables-responsive/dataTables.responsive.js') }} "></script>
  $(document).ready(function() {
      $('#dataTables-example').DataTable({responsive: true});
      $('#dataTables-example_filter').css('float','right');
  });
  -->
  <script type="text/javascript">
      /*
      function openchat() {
          window.open("{{ url('chatPop') }}", "_blank", "toolbar=no,scrollbars=no,resizable=yes,top=100,left=500,width=400,height=400");
      }*/
      app.controller('chat', function($scope, $http, Utility, Resource) {
        //$scope.base= Resource.base;
        $scope.inst= {temp:{}, list: {current:0, data:[]}, lookUp: {current:0, data:[]}};
        $scope.model= {
          primary: {id:null, chatName:"", binds:[]}
        };
      
      $scope.loader= function(){
        $scope.inst.temp= Utility.clone($scope.model.primary);
        Resource.api("chat", "get", null, null, function(res){
          res.data.forEach(function(item, index) {
            item.binds= [];
            item.users.forEach(function(bind, idx){
              item.binds.push(bind.id);
            });
          });
          $scope.inst.list.data= res.data;
          console.log($scope.inst.list.data);
        });
        Resource.api("user", "get", null, null, function(res){
          $scope.inst.lookUp.data= res.data;
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
              this.showError("Not specified ["+ issue + " ]");
              console.log(issue);
              return;
          }

          this.hideModal("#entryForm");
          if($scope.inst.temp.id==null) {
              Resource.api("chat", "create", $scope.inst.temp, $(tag).prop('files'), function(res){
                console.log(res);
                if(res.data.status=="pass"){
                    $scope.inst.temp.id= res.data.id;
                    list.data.push($scope.inst.temp);
                }
              });
          } else {
              Resource.api("chat", "edit", $scope.inst.temp, $(tag).prop('files'), function(res){
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
            Resource.api("chat", "delete", {id: id}, null, function(res){
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
