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
  <div ng-controller="site">
      <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header contentHeader"> Job Site </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Sites
                    <button class="btn btn-success" style="float:right;" ng-click="ui.addRow()"><i class="fa fa-plus"></i></button>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Job Site</th>
                                <th>Region</th>
                                <th>Address</th>
                                <th style="width:30px;"><i class="fa fa-cog"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="oneRow" ng-repeat="(header, value) in (inst.list.data)">
                                <td>[{value.siteName}]</td>
                                <td>[{(inst.lookUp.data | filter:{id:value.region_id}:true)[0].regionName}]</td>
                                <td>[{value.address}]</td>
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
                <b>[{ui.isEdit? "Edit": "Add"}] Site</b>
                <button class="btn" style="float:right" ng-click="ui.hideModal('#entryForm')"> <i class="fa fa-times"></i></button>
            </div>
            <div class="panel-body">
                <div style="width:100%">
                    <label>Name</label> <input class="form-control" type="text" ng-model="inst.temp.siteName">

                    <label>Region</label> <select class="form-control" ng-model="inst.temp.region_id">
                    <option ng-repeat="(header, value) in (inst.lookUp.data)" ng-value="value.id">[{value.regionName}]</option>
                </select>

                <input id="pac-input" style="margin: 2px 2px; text-overflow: ellipsis; width: 300px; height:30px" type="text" placeholder="Search Box" value="Position based">
                <div style="margin:7px; width:100%; height:300px; outline:none" id="map"></div>

                <label>Radius (Meters)</label> <input class="form-control" type="number" value="300" id="mapRadius">
             </div>

            <div style="width:30%; float:right; display:inline-block;margin:7px">
                <button class="btn" style="float:right; clear:none;" ng-click="ui.sendData(inst.list, null)">[{ui.isEdit? "Edit": "Add"}]</button> 
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
    var marker=null;
    var cityCircle= null;
    var map= null;

    function initMap() {
      var uluru = {lat: 31.469178550000002, lng: 74.29872789325681};
      map = new google.maps.Map(document.getElementById('map'), {zoom: 15, center: uluru});
      var geocoder = new google.maps.Geocoder;

      function geocodeLatLng(mark) {
        var latlng = {lat: mark.getPosition().lat(), lng: mark.getPosition().lng()};
         var latlngstr= mark.getPosition();
          geocoder.geocode({'location': latlng}, function(results, status) {
            console.log(status);
            if (status === 'OK')
              document.getElementById('pac-input').value= results[0]? results[0].formatted_address: "Position based";
            else if(status === 'OVER_QUERY_LIMIT')
                document.getElementById('pac-input').value= "Position based";
            else 
              document.getElementById('pac-input').value= "Position based";
          });
        }

      marker = new google.maps.Marker({position: uluru, map: map});
      cityCircle = new google.maps.Circle({ strokeColor: '#8a6d3b', strokeOpacity: 0.8, strokeWeight: 2, fillColor: '#8a6d3b', fillOpacity: 0.35, map: map, center: uluru, radius: 300, });
      google.maps.event.addListener(map, 'click', function(event) {
        marker.setPosition(event.latLng);
        cityCircle.setCenter(event.latLng);
            geocodeLatLng(marker);
        });

      google.maps.event.addDomListener(document.getElementById('mapRadius'), 'change', function(evt) {
        cityCircle.setRadius(parseFloat(document.getElementById('mapRadius').value));
    });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
      });
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();
          if (places.length == 0) return;
          myPlace= places[0];
          //console.log(myPlace.id);
          if (!myPlace.geometry) return;

          var bounds = new google.maps.LatLngBounds();

            if (myPlace.geometry.viewport) {// Only geocodes have viewport.
              bounds.union(myPlace.geometry.viewport); 
          } else {
              bounds.extend(myPlace.geometry.location);
          }
          map.fitBounds(bounds);
      });
    }

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu0qjjO0RhQmqr0DBs0_iYYswNEx-zDZY&libraries=places&callback=initMap"></script>

<script type="text/javascript">
    app.controller('site', function($scope, $window, $http, Utility, Resource) {
      //$scope.base= Resource.base;
      $scope.inst= {temp:{}, list: {current:0, data:[]}, lookUp: {current:0, data:[]}};
      $scope.model= {
        primary: {id:null, siteName:"", address:"Position based", lng:"74.29872789325681", lat:"31.469178550000002", rad:"300", region_id:"",}
    };

    $scope.loader= function(){
        $scope.inst.temp= Utility.clone($scope.model.primary);
        Resource.api("region", "get", null, null, function(res){
            $scope.inst.lookUp.data= res.data;
        });
        Resource.api("site", "get", null, null, function(res){
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
          this.resetMap();
      },
      addRow: function() {
          this.isEdit= false;
          $scope.inst.temp= Utility.clone($scope.model.primary);
          $('#entryForm').show();
          this.resetMap();

      },
      //reset map view to temp data
      resetMap: function(){
          var latlng = {lat: parseFloat($scope.inst.temp.lat), lng: parseFloat($scope.inst.temp.lng)};
          $window.marker.setPosition(latlng);
          $window.cityCircle.setCenter(latlng);
          $window.cityCircle.setRadius(parseFloat($scope.inst.temp.rad));
          document.getElementById('mapRadius').value= $scope.inst.temp.rad;
          document.getElementById('pac-input').value= $scope.inst.temp.address;
          $window.map.setZoom(15);
          $window.map.panTo($window.marker.position);
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
          $scope.inst.temp.lat= $window.marker.getPosition().lat();
          $scope.inst.temp.lng= $window.marker.getPosition().lng();
          $scope.inst.temp.rad= document.getElementById('mapRadius').value;
          $scope.inst.temp.address= document.getElementById('pac-input').value;
          //console.log($scope.inst.temp); return;
          if((issue= this.formValid(["id"])).length > 0) {
              this.showError("Not specified ["+ issue +" ]");
              return;
          }
          files= tag? $(tag).prop('files'): null;
          this.hideModal("#entryForm");

          if($scope.inst.temp.id==null) {
              Resource.api("site", "create", $scope.inst.temp, files, function(res){
                console.log(res);
                if(res.data.status=="pass"){
                    $scope.inst.temp.id= res.data.id;
                    list.data.push($scope.inst.temp);
                }
            });
          } else {
              Resource.api("site", "edit", $scope.inst.temp, files, function(res){
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
            Resource.api("site", "delete", {id: id}, null, function(res){
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
