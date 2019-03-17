<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> EnviroClean </title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href=" {{ asset('vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href=" {{ asset('vendor/sbAdmin/sb-admin-2.css') }}/" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href=" {{ asset('vendor/font-awesome/css/font-awesome.min.css') }} " rel="stylesheet" type="text/css">

    <style>
      .contentHeader {font-size: 2em;}
      .fullloaderBg {width: 100%; height:100%; z-index: 14; position: fixed; background:rgba(255,255,255,1);}
      .fullloader {width:50%; height:50%; z-index: 15; position: relative; top:23%; left:26%; color: #223f7c; background-repeat: no-repeat; background-position: 50% 50%; background-image: url({{ asset("img/loader.gif") }});background-size: 10% 20%;}
    </style>
    @yield('style')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body ng-app="myApp">
        <div class="fullloaderBg">
          <div class="fullloader"></div>
        </div>
        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('dashboard') }}"> <img style="width:80px; display:block; margin:auto; margin-bottom:10px" src="{{ asset('img/logo.png') }}" alt="Logo"></a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <!--
                        <a href="{{ url('/') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        -->
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
                        <!--
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="{{ url('/') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        -->
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                @if(Request::path() == 'dashboard')
                                <a href="#" style="color:green"><i class="fa fa-tachometer fa-fw"></i> Dashboard</a>
                                @else
                                <a href="{{ url('dashboard') }}"><i class="fa fa-tachometer fa-fw"></i> Dashboard</a>
                                @endif
                            </li>
                            <li>
                                @if(Request::path() == 'shift')
                                <a href="#" style="color:green"><i class="fa fa-calendar fa-fw"></i> Schedule</a>
                                @else
                                <a href="{{ url('shift') }}"><i class="fa fa-calendar fa-fw"></i> Schedule</a>
                                @endif
                            </li>
                            <li>
                                @if(Request::path() == 'user')
                                <a href="#" style="color:green"><i class="fa fa-user fa-fw"></i> Manage Users</a>
                                @else
                                <a href="{{ url('user') }}"><i class="fa fa-user fa-fw"></i> Manage Users</a>
                                @endif
                            </li>
                            <li>
                                @if(in_array(Request::path(), array('region', 'site', 'fence')))
                                <a href="#" style="color:green"><i class="fa fa-map-marker fa-fw"></i> Locations<span class="fa arrow"></span></a>
                                @else
                                <a href="#"><i class="fa fa-map-marker fa-fw"></i> Locations<span class="fa arrow"></span></a>
                                @endif

                                <ul class="nav nav-second-level collapse in">
                                    <li>
                                        @if(Request::path() == 'region')
                                        <a href="#" style="color:green"> Regions </a>
                                        @else
                                        <a title="Create a region for manager." href="{{ url('region') }}"> Regions </a>
                                        @endif
                                    </li>
                                    <li>
                                        @if(Request::path() == 'site')
                                        <a href="#" style="color:green"> Sites </a>
                                        @else
                                        <a title="Manage your sites" href="{{ url('site') }}"> Sites </a>
                                        @endif
                                    </li>
                                    <li>
                                        @if(Request::path() == 'fence')
                                        <a href="#" style="color:green"> Fences </a>
                                        @else
                                        <a title="Manage your fences within site" href="{{ url('fence') }}"> Fences </a>
                                        @endif
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                @if(Request::path() == 'violation')
                                <a href="#" style="color:green"><i class="fa fa-file-image-o  fa-fw"></i> Gallery</a>
                                @else
                                <a href="{{ url('violation') }}"><i class="fa fa-file-image-o  fa-fw"></i> Gallery</a>
                                @endif
                            </li>
                            <li>
                                @if(Request::path() == 'chat')
                                <a href="#" style="color:green"><i class="fa fa-comments fa-fw"></i> Messenger</a>
                                @else
                                <a href="{{ url('chat') }}"><i class="fa fa-comments fa-fw"></i> Messenger</a>
                                @endif
                            </li>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->
            <div class="fullloader"></div>
            <div id="page-wrapper">
              <div class="container-fluid">
                 @yield('content')
              </div>
             <!-- /.container-fluid -->
         </div>
         <!-- /#page-wrapper -->

     </div>
     <!-- /#wrapper -->

     <!-- jQuery -->
     <script src=" {{ asset('vendor/jquery/jquery.min.js') }}"></script>
     <script type="text/javascript" src="{{ asset('vendor/jeromeetienne-jquery-qrcode/jquery.qrcode.min.js')}}"></script>

     <!-- Bootstrap Core JavaScript -->
     <script src=" {{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>

     <!-- Metis Menu Plugin JavaScript -->
     <script src=" {{ asset('vendor/metisMenu/metisMenu.min.js') }} "></script>

     <!-- Custom Theme JavaScript -->
     <script src=" {{ asset('vendor/sbAdmin/sb-admin-2.js') }} "></script>

     <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.7.5/angular-sanitize.min.js"></script>
     
     <!-- angular -->
    <script type="text/javascript">
        angular.element(function () {
          document.getElementsByClassName('fullloader')[0].setAttribute("style", "display:none");
          document.getElementsByClassName('fullloaderBg')[0].setAttribute("style", "display:none");
        });
        var app = angular.module('myApp', ['ngSanitize']).config(function($interpolateProvider){
            $interpolateProvider.startSymbol('[{').endSymbol('}]');
        });
        app.filter('range', function() {
          return function(input, total) {
            total = parseInt(total);

            for (var i=0; i<total; i++) {
              input.push(i);
            }

            return input;
          };
        });
        app.directive('dateFormat', function() {
          return {
            require: 'ngModel',
            link: function(scope, element, attr, ngModelCtrl) {
              //Angular 1.3 insert a formater that force to set model to date object, otherwise throw exception.
              //Reset default angular formatters/parsers
              ngModelCtrl.$formatters.length = 0;
              ngModelCtrl.$parsers.length = 0;
            }
          };
        });
        app.constant("CSRF_TOKEN", '{{ csrf_token() }}');
        app.factory('Utility', function($http, CSRF_TOKEN) {
            return {
                
                clone: function(obj) {
                    return JSON.parse(JSON.stringify(obj));
                },
                fmApi: function(url, method, data, files, callback){
                    var fd= new FormData();
                    Object.keys(data).forEach(function(key){ if(key!="id") fd.append(key, data[key])});

                    fd.append("_token", CSRF_TOKEN);
                    if(method=="PUT")
                        fd.append("_method", "PUT");

                    if(files) {
                        for(i=0; i<files.length; i++)
                          fd.append("files[]", files[i]);
                    }

                    $http.post(url, fd, {
                      headers: {
                        'Content-Type': undefined,
                      },
                      transformRequest: angular.identity
                    }).then(function(res){
                      if(res.data.err)
                          alert("Error: " + res.data.err);
                      else if(res.data.redirect)
                          window.location.href= res.data.redirect;
                      else if(res.data.alert)
                          alert(res.data.alert);
                      if(callback!==null)
                          callback(res);
                    });
                },
                //'_token': CSRF_TOKEN, '_method': method? method: "POST"
                jsonApi: function (url, method, data, callback) {
                    var request = $http({
                        method: method,
                        url: url,
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        data: data,
                    });
                    request.then(function (response) {
                        if(response.data.err)
                            alert("Error: " + response.data.err);
                        else if(response.data.redirect)
                            window.location.href= response.data.redirect;
                        else if(response.data.alert)
                            alert(response.data.alert);
                        if(callback!==null)
                            callback(response);
                    });
                },
            };
        });
        app.factory('Resource', function(Utility) {
            return {
                base: "{{url('/')}}/", //"http://demo.fahadhussainkhan.com/",
                api: function(controller, operation, data, files, callback){
                    if(operation=="get")
                        Utility.jsonApi(this.base+controller, "GET", null, callback);
                    else if(operation=="show")
                        Utility.jsonApi(this.base+controller+"/"+data.id, "GET", {"some data": "data"}, callback);
                    else if(operation=="create")
                        Utility.fmApi(this.base+controller, "POST", data, files, callback);
                    else if(operation=="edit")
                        Utility.fmApi(this.base+controller+"/"+data.id, "PUT", data, files, callback);
                    else if(operation=="delete")
                        Utility.jsonApi(this.base+controller+"/"+data.id, "DELETE", null, callback);
                }
            }
        });
    </script>
    @yield('js')
</body>

</html>
