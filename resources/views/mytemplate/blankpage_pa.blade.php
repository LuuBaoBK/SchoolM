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

  @include('mytemplate.header')

  @include('mytemplate.sidebar_pa')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @yield('content')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('mytemplate.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      
    </ul>
    <div class="tab-content">
      <div class="tab-pane" id="control-sidebar-home-tab">
      </div>
     
    </div>
  </aside>
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
<script src="{{asset("/mylib/bower_components/pusher/dist/pusher.min.js")}}"></script>
<script src="{{asset("/mylib/pnotify-master/src/pnotify.js")}}"></script>
<script src="{{asset("/mylib/pnotify-master/src/pnotify.desktop.js")}}"></script>
<script src="{{asset("/mylib/pnotify-master/src/pnotify.buttons.js")}}"></script>
<link rel="stylesheet" href="{{asset("/mylib/pnotify-master/src/pnotify.css")}}">
<link rel="stylesheet" href="{{asset("/mylib/pnotify-master/src/pnotify.buttons.css")}}">
<input type="hidden" id="currentUser" value="{{$currentUser->id}}">
<script type="text/javascript">
function notification(){
  var my_id = $('#currentUser').val();
  var pusher = new Pusher('{{env("PUSHER_KEY")}}');
  var channel = pusher.subscribe(my_id+"-channel");
  var Notification = window.Notification || window.mozNotification || window.webkitNotification;
  var handler = function(data){
    var mail_count = $('#mail_count').html();
    if(mail_count == ""){
      mail_count = 1;
    }
    else{
      mail_count = parseInt(mail_count) +1;
    }
    $('#mail_count').html(mail_count);
    Notification.requestPermission(function (permission) {
      //console.log(permission);
    });
     if (document.hidden) {
      var instance = new Notification(
        "SchoolM", {
          body: data+" sent you an email",
          icon: '/mylib/pnotify-master/includes/le_happy_face_by_luchocas-32.png'
        }
      );
      setTimeout(instance.close.bind(instance), 4000);
     }
     else{
      PNotify.prototype.options.styling = "fontawesome";
      new PNotify({
          title: 'SchoolM',
          text: data+" sent you an email",
          icon: 'fa fa-envelope-o',
          delay: 4000,
          buttons: {
            // closer: true,
            closer_hover: false,
            sticker:false
          },
          desktop: {
            desktop: false,
            fallback: true,
            icon: null,
            tag: null,
            text: data+" sent you an email"
          }  
      });

     }
  };
  var handler2 = function(data){
      Notification.requestPermission(function (permission) {
      });
     if (document.hidden) {
      var instance = new Notification(
        "SchoolM", {
          body: "You have new notice on : "+data['show_date']+" Nid= "+data['nid'],
          icon: '/mylib/pnotify-master/includes/le_happy_face_by_luchocas-32.png'
        }
      );
      setTimeout(instance.close.bind(instance), 4000);
     }
     else{
      PNotify.prototype.options.styling = "fontawesome";
      new PNotify({
          title: 'SchoolM',
          text: "You have new notice on : "+data['show_date']+" Nid= "+data['nid'],
          icon: 'fa fa-envelope-o',
          delay: 4000,
          buttons: {
            // closer: true,
            closer_hover: false,
            sticker:false
          },
          desktop: {
            desktop: false,
            fallback: true,
            icon: null,
            tag: null,
            text: "You have new notice on : "+data['show_date']+" Nid= "+data['nid']
          }  
      });

     }
  };
  channel.bind("new_mail_event",handler);
  channel.bind("new_notice_event",handler2);
}
notification();
</script>
</body>
</html>
