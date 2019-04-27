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
      .fullloader {width: 100%; height:100%; position: absolute; z-index: 14; margin: auto; background:rgba(255,255,255,1);
      background-repeat: no-repeat; background-position: center; background-image: url({{ asset("img/loader.gif") }});
      background-size: 20% 45%;}
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

      <div id="wrapper">
        <div class="fullloader"></div>
        <div class="container-fluid">
           @yield('content')
        </div>
        <!-- /.container-fluid -->
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

     <script src=" {{ asset('vendor/angular/angular.min.js') }} "></script>
     <script src=" {{ asset('vendor/angular/angular-sanitize.min.js') }} "></script>
  <!--
     <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.7.5/angular-sanitize.min.js"></script>
     -->
     <!-- angular -->
    <script type="text/javascript">
        angular.element(function () {
          document.getElementsByClassName('fullloader')[0].setAttribute("style", "display:none");
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
        app.constant("ROLE", '{{ isset(Auth::user()->type)? Auth::user()->type:"Guest" }}');
        app.constant("ID", '{{ isset(Auth::user()->id)? Auth::user()->id:null }}');
        app.constant("NAME", '{{ isset(Auth::user()->name)? Auth::user()->name:null }}');
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
