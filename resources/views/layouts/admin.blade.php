<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> Enviro Clean </title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href=" {{ asset('vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href=" {{ asset('vendor/sbAdmin/sb-admin-2.css') }}/" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href=" {{ asset('vendor/font-awesome/css/font-awesome.min.css') }} " rel="stylesheet" type="text/css">

    @yield('style')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

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
                <a class="navbar-brand" href="index.html"> Enviro Clean</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
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
                                <a href="#" style="color:green"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                            @else
                                <a href="{{ url('dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                            @endif
                        </li>
                        <li>
                            @if(in_array(Request::path(), array('region', 'site', 'fence')))
                                <a href="#" style="color:green"><i class="fa fa-map-marker fa-fw"></i> Locations<span class="fa arrow"></span></a>
                            @else
                                <a href="#"><i class="fa fa-map-marker fa-fw"></i> Locations<span class="fa arrow"></span></a>
                            @endif
                            
                            <ul class="nav nav-second-level">
                                <li>
                                    @if(Request::path() == 'region')
                                        <a href="#" style="color:green"> Regions </a>
                                    @else
                                        <a href="{{ url('region') }}"> Regions </a>
                                    @endif
                                </li>
                                <li>
                                    @if(Request::path() == 'site')
                                        <a href="#" style="color:green"> Sites </a>
                                    @else
                                        <a href="{{ url('site') }}"> Sites </a>
                                    @endif
                                </li>
                                <li>
                                    @if(Request::path() == 'fence')
                                        <a href="#" style="color:green"> Fences </a>
                                    @else
                                        <a href="{{ url('fence') }}"> Fences </a>
                                    @endif
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            @if(Request::path() == 'users')
                                <a href="#" style="color:green"><i class="fa fa-user fa-fw"></i> Users</a>
                            @else
                                <a href="{{ url('users') }}"><i class="fa fa-user fa-fw"></i> Users</a>
                            @endif
                        </li>
                        <li>
                            @if(Request::path() == 'schedule')
                                <a href="#" style="color:green"><i class="fa fa-calendar fa-fw"></i> Schedule</a>
                            @else
                                <a href="{{ url('schedule') }}"><i class="fa fa-calendar fa-fw"></i> Schedule</a>
                            @endif
                        </li>
                        <li>
                            @if(Request::path() == 'chat')
                                <a href="#" style="color:green"><i class="fa fa-comments fa-fw"></i> Chat</a>
                            @else
                                <a href="{{ url('chat') }}"><i class="fa fa-comments fa-fw"></i> Chat</a>
                            @endif
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
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

    <!-- Bootstrap Core JavaScript -->
    <script src=" {{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src=" {{ asset('vendor/metisMenu/metisMenu.min.js') }} "></script>

    @yield('js')

    <!-- Custom Theme JavaScript -->
    <script src=" {{ asset('vendor/sbAdmin/sb-admin-2.js') }} "></script>
</body>

</html>
