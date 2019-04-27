@extends('layouts.onePage')

@section('style')
<style type="text/css">
    .panel {margin:0px; height:100vh; width: 100%; position: absolute; overflow-y:scroll}
    .errspan {font-size:20px; float: right; margin-right: 6px; margin-top: -25px; position: relative; z-index: 2; margin-left:10px}
    .chatCard {background: red; border-radius: 7px; padding:5px; color:white; clear:both; width:70%; margin-bottom: 7px;}
    .otherPerson{float:left;   background: #c7cbd0;}
    .person{float:right; background: #84b7ea;}
    ::-webkit-scrollbar {
      width: 0px;
    }
</style>
@endsection

@section('content')
<div ng-controller="chat">
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
                  [{ui.getPersonName()}]
              </div>
              <!-- /.panel-heading -->
              <div class="panel-body">
                  <div id="chatArea" style="overflow-y: scroll; height:73vh;">
                    <!--
                      <span class="chatCard otherPerson">Hello, John. How are you?</span>
                      <span class="chatCard person">I am just fine. And how are you, Martha?</span>
                      fa-paper-plane
                      -->
                      <!-- -->
                  </div>
                  <div>
                      <input id="sendArea" class="form-control" type="text" ng-model="ui.messageSpace" onchange="angular.element(this).scope().ui.sendMessage('#sendArea')">
                      <span id="speaker" ng-style="{'color': ui.recordColor}" class="fa fa-paper-plane errspan" ng-mousedown="ui.sendMessage('#sendArea')"></span>
                  </div>
              </div>
              <!-- /.panel-body -->
          </div>
          <!-- /.panel -->
      </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->  
</div>
@endsection

@section('js')
<!-- DataTables JavaScript -->
<script src=" {{ asset('vendor/datatables/js/jquery.dataTables.min.js') }} "></script>
<script src=" {{ asset('vendor/datatables-plugins/dataTables.bootstrap.min.js') }} "></script>
<script src=" {{ asset('vendor/datatables-responsive/dataTables.responsive.js') }} "></script>

<script src="https://www.gstatic.com/firebasejs/3.5.3/firebase.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
      $('#dataTables-example').DataTable({responsive: true});
      $('#dataTables-example_filter').css('float','right');
  });
  var config = {
    apiKey: "AIzaSyDJJWn71rtqQkfCIHQgRBcnMNn0jH_IE3M",
    databaseURL: "https://envirochatbase.firebaseio.com/",
    storageBucket: "gs://envirochatbase.appspot.com",
  };
  firebase.initializeApp(config);
  const ref= firebase.database().ref();
  var rec = firebase.storage().ref();

  app.controller('chat', function($scope, $http, Utility, Resource, ROLE, ID, NAME) {
    $scope.inst= {lookUp: {current:0, data:[]}};
    $scope.loader= function(){
      Resource.api("user", "get", null, null, function(res){
        res.data.forEach(function(item){ item.password=""; });
        $scope.inst.lookUp.data= res.data;
      });
      //$scope.ui.setupRecorder();
      ref.on("value", function(snapshot) {
        //$scope.ui.roomData= snapshot.child("Chats").child("{{urldecode($header)}}").val();
        //console.log($scope.ui.roomData);
        fbGroup= snapshot.child("Chats");
        $("#chatArea").empty();
        fbGroup.forEach(obj => {
          item= obj.val();
          //console.log(item);
          if(item.receiver==ID && item.sender=="{{urldecode($header)}}"){
            $("#chatArea").append('<span class="chatCard otherPerson">' + $scope.ui.getUser(item.sender).name + ": " + item.message + `</span>
            `);
          } else if (item.sender==ID && item.receiver=="{{urldecode($header)}}"){
            $("#chatArea").append('<span class="chatCard person">' + "You: " + item.message + `</span>
            `);
          }
        });
        $("#chatArea").animate({scrollTop: $("#chatArea").prop("scrollHeight")});
        $scope.$evalAsync();
      }, function (errorObject) {
        console.log("The read failed: " + errorObject.code);
      });
    };

    $scope.ui = {
      roomData: {},
      messageSpace: "",
      mediaRecorder: null,
      recordColor: "green",
      getUser: function(id){
        return $scope.inst.lookUp.data.filter((item)=>{
          return item.id==id;
        })[0];
      },
      getPersonName: function(){
        var otherUser= this.getUser({{urldecode($header)}});
        if(otherUser)
          return otherUser.name;
        else
          return "Guest"
      },
      sendMessage: function(id){
        //console.log($(id).val());
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        if (dd < 10) dd = '0' + dd;
        if (mm < 10) mm = '0' + mm;
        var dated = dd + ' ' + mm + ', ' + yyyy;

        var h = today.getHours();
        var m = today.getMinutes();
        var tlvehr = (h >= 12 ? ' PM' : ' AM')
        if (m < 10)  m = '0' + m;
        if (h < 10)  h = '0' + h;
        var timed= h + ":" + m + tlvehr;

        if($scope.ui.messageSpace=="")
          return;
        ref.child("Chats").push({
          
          isSeen: false,
          message: $scope.ui.messageSpace,
          time: timed,
          date: dated,
          sender: ID+"",
          receiver: "{{urldecode($header)}}"
        });
        $scope.ui.messageSpace= ""
      },
      setupRecorder: function() {
        //chrome://flags/#unsafely-treat-insecure-origin-as-secure
        navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
          if($scope.ui.mediaRecorder==null)
            $scope.ui.mediaRecorder= new MediaRecorder(stream);

          audioChunks = [];
          $scope.ui.mediaRecorder.addEventListener("dataavailable", event => {
            audioChunks.push(event.data);
          });

          $scope.ui.mediaRecorder.addEventListener("stop", () => {
            if($scope.ui.audio==null) {
              audio = new Audio();
              audio.loop= false;
            }
            blob= new Blob(audioChunks, {type: 'audio/mpeg-3'});
            audioChunks= []; //clear chunk

            audio.src= URL.createObjectURL(blob);
            audio.play();
            
            rec.child("recordings/recording.mp3").put(new File([blob], "recording.mp3"), {contentType: 'audio/mpeg-3'}).then(function(snapshot) {
                ref.child("chatRooms").child("{{$header}}").child("lastMessage").set(
                  {"type": "audio", "content": snapshot.downloadURL, "sender": "{{$username}}", "id": "{{$id}}"}
                );
                $("#chatArea").append('<span class="chatCard person">' + $scope.ui.roomData.lastMessage.sender + ' <audio controls style="width:200px;"> <source src="'+$scope.ui.roomData.lastMessage.content+'" type="audio/mpeg"> </audio></span>');
            });
          });
        });
      },
      startRecord: function(){
        $scope.ui.mediaRecorder.start();
        $scope.ui.recordColor= "red";
        console.log("Recording started.");
      },
      stopRecord: function(){
        $scope.ui.recordColor= "green";
        if($scope.ui.mediaRecorder!=null) {
          $scope.ui.mediaRecorder.stop();
          console.log("Recording stopped.");
        }
        else
          console.log("Audio recording failed.");
      },
    }
    $scope.loader();
  });
</script>
@endsection
