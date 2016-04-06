<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SCHOOLM</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="{{asset("/adminlte/bootstrap/css/bootstrap.min.css")}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset("/adminlte/onlinelib/font-awesome-4.4.0/css/font-awesome.min.css")}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset("/adminlte/onlinelib/ionicons-2.0.1/ionicons-2.0.1/css/ionicons.min.css")}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset("/adminlte/plugins/datatables/dataTables.bootstrap.css")}}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{asset("/adminlte/plugins/iCheck/all.css")}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset("/adminlte/dist/css/AdminLTE.min.css")}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset("/adminlte/dist/css/skins/_all-skins.min.css")}}">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <header class="main-header">
        <a href="#" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b>LT</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>School</b>M</span>
        </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        </a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
        </button>
    <div class="container-fluid">
    <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <form id="form_login" style="margin-top : 5px" action="auth/login" method="post" class="navbar-form navbar-right form-horizontal">
            <!-- <ul class="nav navbar-nav navbar-right">     -->
            {!! csrf_field() !!}
                <div style = "margin-top: 2px; margin-right: 0px" class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="User Email"/>
                    <input type="password" name="password" class="form-control" placeholder="Password"/>
                    <button style="display:none" type="submit" class="btn bg-olive btn-block">Sign me in</button>
                </div>  
            <!-- </ul> -->
            </form>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <div id="resultModal" class="modal modal-warning">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Error</h4>
            </div>
            <div class="modal-body">
                <p>Email or Password is incorrect</p>
            </div>
            <div class="modal-footer">
                <button class="close" type="button" class="btn btn-primary pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
  <!-- /.modal-dialog -->
</div>
</header>
  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <h4>|</h4>
        </div>
        <!-- <div class="pull-left info">
          <p>Hello,<?php  $user = (Auth::check() ? Auth::user()->lastname : "guest").' !'; echo ' '.$user ?></p>
        </div> -->
      </div>
        <div class="pull-left info">
          <img style="margin-left : 12px" src="/mybanner.png">
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <!-- <ul class="sidebar-menu">
            <li class="active">
                <a href="#">
                    <i class="fa fa-home"></i> 
                    <span>About School</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Contact Info</span>
                </a>
            </li>
        </ul> -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          HCM City High School
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-lg-4">
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-bookmark"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">HCM High School</span>
              <span class="info-box-number">{{$record['year']}}<sup>th</sup></span>
              <!-- The progress section is optional -->
              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <span class="progress-description">
                {{$record['year']}} years and over
              </span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div>
        <div class="col-lg-4">
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-male"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Teacher</span>
              <span class="info-box-number">{{$record['num_teacher']}}</span>
              <!-- The progress section is optional -->
              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <span class="progress-description">
                Best Teacher In HCM
              </span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div>
        <div class="col-lg-4">
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-graduation-cap"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Students</span>
              <span class="info-box-number">{{$record['num_student']}}</span>
              <!-- The progress section is optional -->
              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <span class="progress-description">
               5% Total Student In HCM City  
              </span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div>
      </div>
      <div class="box box-primary box-solid">
        <div class="box-header">
          <h3 class="text-center" style="font-size:35px">My School</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-lg-4">
              <div class="box box-primary">
                <div class="box-header">
                  <h4 class="text-center">Number Of Student</h4>
                </div>
                <div class="box-body">
                  <div class="box-body">
                    <div class="chart">
                      <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                      <canvas id="lineChart" style="height:450px  "></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8">
              <div class="box box-primary">
                <div class="box-header">
                  <h4 class="text-center">Commitment To Quality</h4>
                </div>
                <div class="box-body">
                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>Teaching</b>: Best teacher with best equipment for each class.
                    </li>
                    <li class="list-group-item">
                      <b>Entertainment</b>: Lots of extracurricular activities and club.
                     </li>
                    <li class="list-group-item">
                      <b>Result</b> will be graduated with B<sup>+</sup> certificate.
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('mytemplate.footer')

  <!-- Control Sidebar -->
  <!-- <aside class="control-sidebar control-sidebar-dark">
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      
    </ul>
    <div class="tab-content">
      <div class="tab-pane" id="control-sidebar-home-tab">
      </div>
     
    </div>
  </aside> -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div> 
</div>
<!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- InputMask -->
<script src="{{asset("/adminlte/plugins/input-mask/jquery.inputmask.js")}}"></script>
<script src="{{asset("/adminlte/plugins/input-mask/jquery.inputmask.date.extensions.js")}}"></script>
<script src="{{asset("/adminlte/plugins/input-mask/jquery.inputmask.extensions.js")}}"></script>
<!-- SlimScroll -->
<script src="{{asset("/adminlte/plugins/slimScroll/jquery.slimscroll.min.js")}}"></script>
<!-- FastClick -->
<script src="{{asset("/adminlte/plugins/fastclick/fastclick.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{asset("/adminlte/dist/js/app.min.js")}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset("/adminlte/dist/js/demo.js")}}"></script>
<!-- DataTables -->
<script src="{{asset("/adminlte/plugins/datatables/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("/adminlte/plugins/datatables/dataTables.bootstrap.min.js")}}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{asset("/adminlte/plugins/iCheck/icheck.min.js")}}"></script>
<script src="{{asset("/adminlte/plugins/chartjs/Chart.min.js")}}"></script>
@if(Session::has('alert-warning'))
  <script type="text/javascript">
    $(function() {
      $('#resultModal').show();
      $('.close').click(function(){
        $('#resultModal').hide();
      });
    });
  </script>
@endif
  <script type="text/javascript">
    $(function(){
      $('input').keypress(function (e) {
        if (e.which == 13) {
            $('form#form_login').submit();
            return false;    //<---- Add this line
        }
      });
    });

    function draw_chart(){
      var token           = $('input[name="_token"]').val();
      $.ajax({
        url     :"<?= URL::to('/get_info') ?>",
        type    :"POST",
        async   :false,
        data    :{
            '_token'           :token
        },
        success:function(record){
          var areaChartData = {
            labels: record.labels,
            datasets: [
              {
                label: "Electronics",
                fillColor: "rgba(210, 214, 222, 1)",
                strokeColor: "rgba(210, 214, 222, 1)",
                pointColor: "rgba(210, 214, 222, 1)",
                pointStrokeColor: "#c1c7d1",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: record.data
              }
            ]
          };
          var areaChartOptions = {
            //Boolean - If we should show the scale at all
            showScale: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: false,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - Whether the line is curved between points
            bezierCurve: true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot: false,
            //Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true
          };

          var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
          var lineChart = new Chart(lineChartCanvas);
          var lineChartOptions = areaChartOptions;
          lineChartOptions.datasetFill = false;
          lineChart.Line(areaChartData, lineChartOptions);
        },
        error:function(){
            alert("something went wrong, contact master admin to fix");
        }
      });
    }
    draw_chart();

  </script>
</body>
</html>
