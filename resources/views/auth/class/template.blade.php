<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>AdminLTE | Dashboard</title>
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

            
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Class Data Table</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    @yield('content')
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->


        <!-- jQuery 2.0.2 -->
        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script src="{{ URL::asset("adminltemaster/js/jquery.min.js") }}" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="{{ URL::asset("adminltemaster/js/bootstrap.min.js") }}" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="{{ URL::asset("adminltemaster/js/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
        <script src="{{ URL::asset("adminltemaster/js/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="{{ URL::asset("adminltemaster/js/AdminLTE/app.js")}}" type="text/javascript"></script>

        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>
        
    </body>
</html>