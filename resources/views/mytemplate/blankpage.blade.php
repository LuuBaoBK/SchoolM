<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>School M</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="{{asset("/adminltemaster/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="{{asset("/adminltemaster/css/font-awesome.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="{{asset("/adminltemaster/css/ionicons.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="{{asset("/adminltemaster/css/datatables/dataTables.bootstrap.css")}}" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{asset("/adminltemaster/css/AdminLTE.css")}}" rel="stylesheet" type="text/css" />
        <!-- Table data -->
        <link href="{{asset("/adminltemaster/css/datatables/dataTables.bootstrap.css")}}" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
           @include('mytemplate.header')
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
           @include('mytemplate.sidebar')

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                @yield('content')
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- jQuery 2.0.2 -->
        <script src="{{ URL::asset("adminltemaster/js/jquery.min.js") }}" type="text/javascript"></script>
        <!-- Bootstrap -->

        <script src="{{ URL::asset("adminltemaster/js/bootstrap.min.js") }}" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="{{ URL::asset("adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
        <script src="{{ URL::asset("adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>

        <script src="{{asset("/adminltemaster/js/bootstrap.min.js")}}" type="text/javascript"></script>
        <!-- Morris.js charts -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="{{asset("/adminltemaster/js/plugins/morris/morris.min.js")}}" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="{{asset("/adminltemaster/js/plugins/sparkline/jquery.sparkline.min.js")}}" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="{{asset("/adminltemaster/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js")}}" type="text/javascript"></script>
        <script src="{{asset("/adminltemaster/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js")}}" type="text/javascript"></script>
        <!-- fullCalendar -->
        <script src="{{asset("/adminltemaster/js/plugins/fullcalendar/fullcalendar.min.js")}}" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{asset("/adminltemaster/js/plugins/jqueryKnob/jquery.knob.js")}}" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="{{asset("/adminltemaster/js/plugins/daterangepicker/daterangepicker.js")}}" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="{{asset("adminltemaster/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="{{asset("/adminltemaster/js/plugins/iCheck/icheck.min.js")}}" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="{{asset("/adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
        <script src="{{asset("/adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}"s type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="{{ URL::asset("adminltemaster/js/AdminLTE/app.js")}}" type="text/javascript"></script>
        <!-- InputMask -->
        <script src="{{asset("/adminltemaster/js/plugins/input-mask/jquery.inputmask.js")}}" type="text/javascript"></script>
        <script src="{{asset("/adminltemaster/js/plugins/input-mask/jquery.inputmask.date.extensions.js")}}" type="text/javascript"></script>
        <script src="{{asset("/adminltemaster/js/plugins/input-mask/jquery.inputmask.extensions.js")}}" type="text/javascript"></script>
        
    </body>
</html>